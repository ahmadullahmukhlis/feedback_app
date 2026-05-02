<?php

namespace App\Http\Controllers;

use App\Events\ResponseEvent;
use App\Models\Support;
use App\Models\SupportResponse;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Events\SupportMessageSent;
use App\Http\Resources\UserLoadResource;
use Carbon\Carbon;

class SupportController extends Controller
{
    //

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'message' => 'required|string',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = Storage::putFile('public/support_images', $request->file('image'));
        }

        $message =  Support::create([
            'user_id' => $request->user()->id,
            'message' => $validatedData['message'],
            'imagePath' => $imagePath
        ]);
        event(new SupportMessageSent($message));
        return response()->json(['message' => 'Support request submitted successfully'], 201);
    }
  public function index(Request $request)
{
    $page = (int) $request->query('page', 0);
    $limit = (int) $request->query('limit', 20);

    // Load supports with responses (EAGER LOADING)
    $supports = Support::with(['responses' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])
        ->where('user_id', $request->user()->id)
        ->orderBy('created_at', 'asc')
        ->skip($page * $limit)
        ->take($limit)
        ->get();

    $data = [];

    foreach ($supports as $support) {

        // USER MESSAGE
        $data[] = [
            'message' => $support->message,
            'isUser' => true,
            'imagePath' => $support->imagePath
                ? asset(Storage::url($support->imagePath))
                : null,
            'created_at' => $support->created_at,
        ];

        // SUPPORT RESPONSES
        foreach ($support->responses as $res) {
            $data[] = [
                'message' => $res->message,
                'isUser' => false,
                'imagePath' => null,
                'created_at' => $res->created_at,
            ];
        }
    }

    return response()->json($data);
}
    public function people()
    {
        $user = User::whereRelation('support', 'user_id', '!=', null)->get();
        return response()->json(['data' => UserLoadResource::collection($user)]);
    }
    public function getMessage($id)
    {

        // Get messages for the user, newest first
        $supports = Support::where('user_id', $id)
            // ->orderBy('created_at', 'desc')
            ->get();

        $data = [];

        foreach ($supports as $support) {
            // User message
            $data[] = [
                'id' => $support->id,
                'message' => $support->message,
                'is_admin' => false,
                'imagePath' => $support->imagePath ? asset(Storage::url($support->imagePath)) : null,
                'created_at' => $support->created_at,
            ];

            // Support response (if exists)
            $responses = SupportResponse::where('support_id', $support->id)
                // ->orderBy('created_at', 'asc') // oldest first
                ->get();

            if ($responses->isNotEmpty()) {
                foreach ($responses as $res) {
                    $data[] = [
                        'id' => $res->id,
                        'message' => $res->message,
                        'is_admin' => true,
                        'imagePath' => null,
                        'created_at' => $res->created_at,
                    ];
                }
            }
        }

        // Reverse array so oldest message is first for Flutter reverse list
        $data = ($data);

        return response()->json([
            'data' => $data,
        ]);
    }
    public function responseMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $id = null;
        $support_id = $request->reply_id;

        if ($support_id) {
            $support = Support::where('id', $support_id)
                ->where('user_id', $request->user_id)
                ->first();

            $id = $support?->id;
        }

        if (!$id) {
            $data = Support::where('user_id', $request->user_id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($data) {
                $id = $data->id;
            } else {
                return response()->json(['message' => 'No support request found for this user.'], 404);
            }
        }

        $message = SupportResponse::create([
            'support_id' => $id,
            'message' => $request->message,
            'admin_id' => auth()->user()->id,
        ]);
        $data = [
            'message' => $message->message,
            'isUser' => false,
            'imagePath' =>  null,
            'created_at' => $message->created_at,
            'user_id' => $request->user_id,
        ];
        event(new ResponseEvent($data, $request->user_id));

        return response()->json(['message' => 'Support request submitted successfully'], 201);
    }
    public function profile()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        $data  =  [
            'id' => $user->id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email,
            'image' => $user->image,
        ];
        return response()->json($data);
    }
    public function statistics()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek = Carbon::now()->endOfWeek();     // Sunday

        $week = Support::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $month = Support::whereMonth('created_at', Carbon::now()->month)->count();
        $weeklyUser = User::where('google_id', '!=', null)->count();
        $monthlyUser = User::whereMonth('created_at', Carbon::now()->month)->count();
        return response()->json([
            'data' => [
                'week_m' => $week,
                'month_m' => $month,
                'weekly_user' => $weeklyUser,
                'monthly_user' => $monthlyUser,
            ]

        ]);
    }
    public function chart()
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $weeklyBreakdown = [];
        $totalWeekCount = 0;

        // Count messages per day this week
        foreach ($daysOfWeek as $dayName) {
            $date = Carbon::now()->startOfWeek()->copy()->addDays(array_search($dayName, $daysOfWeek));
            $count = Support::whereDate('created_at', $date->toDateString())->count();
            $weeklyBreakdown[$dayName] = $count;
            $totalWeekCount += $count;
        }

        // Prepare final weekly array
        $colors = ['blue', 'blue', 'blue', 'blue', 'green', 'orange', 'red'];
        $weeklyBreakdownArray = [];

        foreach ($daysOfWeek as $index => $dayName) {
            $count = $weeklyBreakdown[$dayName];
            $value = $totalWeekCount ? round($count / $totalWeekCount, 2) : 0;
            $percentage = $totalWeekCount ? round(($count / $totalWeekCount) * 100) : 0;

            $weeklyBreakdownArray[] = [
                'name' => $dayName,
                'count' => $count,
                'value' => $value,
                'percentage' => $percentage,
                'color' => $colors[$index] ?? 'blue',
            ];
        }

        // ---------- Monthly Trends ----------
        $monthlyTrends = [];
        $previousMonthCount = 0;

        // Start from 6 months ago (including current month)
        $start = Carbon::now()->subMonths(5)->startOfMonth();

        for ($i = 0; $i < 6; $i++) {
            $date = $start->copy()->addMonths($i);

            $count = Support::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $change = $previousMonthCount
                ? round((($count - $previousMonthCount) / $previousMonthCount) * 100, 1)
                : 0;

            $monthlyTrends[] = [
                'name' => $date->format('M Y'), // e.g. "Mar 2025"
                'messages' => $count,
                'change' => $change,
            ];

            $previousMonthCount = $count;
        }

        // ---------- Return Final Array ----------
        $data = [
            'weeklyBreakdown' => $weeklyBreakdownArray,
            'monthlyTrends' => $monthlyTrends,
        ];
        return response()->json(['data' => $data]);
    }

    public function currentUser()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek = Carbon::now()->endOfWeek();
        $suser = User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $replays = SupportResponse::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $users = User::whereNotIn('id', [1, 2,])->count();
        $data = [
            'suser' => $suser,
            'replays' => $replays,
            'users' => $users,
        ];
        return response()->json(['data' => $data]);
    }
}
