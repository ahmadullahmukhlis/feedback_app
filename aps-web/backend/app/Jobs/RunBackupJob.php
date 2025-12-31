<?php

namespace App\Jobs;

use App\Events\NotificationPushedEvent;
use App\Models\BackupHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class RunBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $userId;
    protected $existFiles;

    public function __construct($userId, $existFiles)
    {
        $this->userId = $userId;
        $this->existFiles = $existFiles;
    }

    public function handle(): void
    {
        Artisan::call('backup:run');

        $files = Storage::disk('public')->files('backups');
        $last_file = end($files);
        $file_size = Storage::disk('public')->size($last_file);
        $path = asset('storage/'.$last_file);
        $file_name_array = explode('/', $last_file);
        $file_name = end($file_name_array);
        BackupHistory::query()->whereNotIn('path', $this->existFiles)->delete();
        $backup = BackupHistory::query()->create([
            'user_id' => $this->userId,
            'path' => $path,
            'name' => $file_name,
            'size' => $file_size
        ]);
        event(new NotificationPushedEvent('BackupHistory', $file_name." backup succeed", 'notification-system-backup-notifications', $backup->id));
    }
}
