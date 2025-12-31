<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        return Notification::query()
            ->limit(11)
            ->orderBy('created_at', 'desc')
            ->whereIn('permissions', [...auth()->user()->permissions(), "for-all"])
            ->get()
            ->toArray();
    }
    public function destroy(Request $request, $id){
        Notification::query()->find($id)->delete();
    }
}
