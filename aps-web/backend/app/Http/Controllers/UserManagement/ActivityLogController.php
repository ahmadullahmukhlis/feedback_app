<?php

namespace App\Http\Controllers\UserManagement;

use App\Helpers\DatatableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserManagement\ActivityLogResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request){
        $query = Activity::query()->with(['causer']);
        if($request->get('from') && $request->get('to')){
            $query = $query->whereBetween('created_at', [Carbon::parse($request->get('from')), Carbon::parse($request->get('to'))->addDay(1)]);
        }
        if($request->has('events')){
            $events = collect($request->get('events'))->map(fn($event)=>$event['name'])->toArray();
            $query = $query->whereIn('description', $events);
        }
        if($request->has('users')){
            $ids = collect($request->get('users'))->map(fn($item)=>$item['id']);
            $query = $query->whereIn('causer_id', $ids);
        }
        $datatable = new DatatableBuilder($query, ['description', 'subject_type', 'log_name']);
        return ActivityLogResource::collection($datatable->build());
    }
    public function getUserLog(User $user){
        $this->allowed('log-activity-access');
        $query = Activity::query()->with(['causer'])->where('causer_id', $user->id);
        $datatable = new DatatableBuilder($query, ['description', 'subject_type', 'log_name']);
        return ActivityLogResource::collection($datatable->build());
    }

    public function getActivityLog(Activity $log){
        $this->allowed('log-activity-view-details');
        return $log;
    }

    public function restoreLog(Activity $log){
        $this->allowed('log-activity-recover-deleted-record');
        $model = $log->subject_type;
        $deleted_data = $log->properties['old'];
        unset($deleted_data['created_at']);
        unset($deleted_data['updated_at']);
        try {
            $model::create($deleted_data);
            return response()->json([
                'result' => true,
                'message' => 'Restored successfully'
            ]);
        }catch (\Exception $exception){
            Log::error($exception);
            return response()->json([
                'result' => false,
                'message' => 'This record was already restored'
            ]);
        }
        /*$deleted_data = $request->get('data')['properties']['old'];
        unset($deleted_data['created_at']);
        unset($deleted_data['updated_at']);
        try {
            $model::create($deleted_data);
        }catch (\Exception $exception){
            Log::error($exception);
            return back()->with(['message' => translate('This record is already restored'), 'type' => 'error']);
        }
        return $log;*/
    }
}
