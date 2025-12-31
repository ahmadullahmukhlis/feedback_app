<?php

namespace App\Http\Controllers\Configurations;

use App\Events\BackupRestoringEvent;
use App\Helpers\DatatableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Resources\Configurations\BackupResource;
use App\Jobs\RunBackupJob;
use App\Models\BackupHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupController extends Controller
{
    public function index(Request $request ){
        $this->allowed('backup-access');
        $query = BackupHistory::query()->with(['user']);
        $datatable = new DatatableBuilder($query, ['name', 'path']);
        return BackupResource::collection($datatable->build());
    }

    public function run(){
        $files = Storage::disk('public')->files('backups');
        $files = collect($files)->map(fn($file)=>asset('storage/'.$file));
        RunBackupJob::dispatch(auth()->id(), $files);
        return response()->json([
            'result' => true,
            'message' => 'Backup is running. Once it finishes system will give you notification'
        ]);
    }

    public function list(){
        return [
            'backups' => cache()->get('backups'),
            'current_db' => env('DB_DATABASE')
        ];
    }

    public function store(Request $request ){
        $this->allowed('backup-restore-backup');
        $file_name_array = explode('/', $request->path);
        $file = end($file_name_array);
        $folder_name = $file_name_array[count($file_name_array) - 2];
        $full_file_path = $folder_name.'/'.$file;
        $zip_path = storage_path('/app/backup_extracted');
        $env_file_location = base_path();
        $env = File::get($env_file_location.'/.env');
        if(Storage::disk('public')->exists($full_file_path)){
            event(new BackupRestoringEvent('Current system backup started'));
            try {
                Artisan::call('backup:run');
            }
            catch (\Exception $exception){
                Log::error($exception);
            }
            event(new BackupRestoringEvent('Current system backup finished'));
            if(!File::exists($zip_path)){
                File::makeDirectory($zip_path);
            }
            $backup_zip_path = storage_path('app/public/backups/'.$file);
            event(new BackupRestoringEvent('Trying to switch to backup'));
            $zip = new ZipArchive;
            if($zip->open($backup_zip_path, ZipArchive::CHECKCONS)){
                $zip->setPassword('Edris@123');
                $zip->extractTo($zip_path);
                $zip->close();

            }
            $exists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$file]);
            if($exists){
                DB::statement('DROP DATABASE `'.$file.'`');
            }

            DB::statement('CREATE DATABASE `'.$file.'`;');
            $sql = Storage::disk('local')->get('/backup_extracted/db-dumps/mysql-'.env('DB_DATABASE').'.sql');
            DB::purge('mysql');
            Config::set('database.connections.mysql.database', $file);
            DB::unprepared($sql);
            DB::reconnect('mysql');
            $env = str_replace([
                'DB_DATABASE=ims_backend',
                'DB_USERNAME=root',
                'DB_PASSWORD=',
            ], [
                'DB_DATABASE='.$file,
                'DB_USERNAME=readonly',
                'DB_PASSWORD=password',
            ], $env);
            File::delete($env_file_location.'/.env');
            File::put($env_file_location.'/.env', $env);
            $backups = cache()->get('backups', []);
            if(!$backups){
                return cache()->remember('backups', 60*60*24, function() use ($file){
                    return [$file];
                });
            }
            if(!in_array($file, $backups)){
                $backups[] = $file;
                cache()->put('backups', $backups, 60*60*24);
            }
            return [
                'result' => true
            ];
        }else{
            return [
                'result' => false,
                'message' => 'File does not exist'
            ];
        }
    }

    public function change(Request $request){
        $env_file_location = base_path();
        $env = File::get($env_file_location.'/.env');
        $db_name = $request->get('db');
        $main_db = env("MAIN_DB");
        if($db_name == "current"){
            $env = str_replace([
                'DB_DATABASE='.env("DB_DATABASE"),
                'DB_USERNAME='.env("DB_USERNAME"),
                'DB_PASSWORD='.env('DB_PASSWORD'),
            ], [
                'DB_DATABASE='.$main_db,
                'DB_USERNAME=root',
                'DB_PASSWORD=',
            ], $env);
        }else{
            $env = str_replace([
                'DB_DATABASE='.env("DB_DATABASE"),
                'DB_USERNAME='.env("DB_USERNAME"),
                'DB_PASSWORD='.env('DB_PASSWORD'),
            ], [
                'DB_DATABASE='.$db_name,
                'DB_USERNAME=readonly',
                'DB_PASSWORD=password',
            ], $env);
        }

        File::delete($env_file_location.'/.env');
        File::put($env_file_location.'/.env', $env);
        return [
            'result' => true,
            'message' => "Successfully changed database"
        ];
    }
    public function destroy (Request $request, $db){
        $backups = cache()->get('backups');
        $backups = collect($backups)->filter(fn($db_)=>$db_!=$db)->toArray();
        cache()->put('backups', $backups, 60*60*24);
        DB::statement('DROP DATABASE `'.$db.'`;');
        return response()->noContent();
    }
}
