<?php
namespace App\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

    class Helpers
{
    public static function removeImageFromUrl($url) : void {
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];
        $absolutePath = public_path($path);
        if(File::exists($absolutePath)){
            File::delete($absolutePath);
        }
    }
    public static function formatFileSize($bytes) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
    public static function filterByDates($query, $field_name='created_at'){
        $date = request()->get('date');
        $from_date = request()->get('from_date');
        $to_date = request()->get('to_date');

        switch ($date) {
            case 'TODAY':
                $query = $query->whereDate($field_name, Carbon::today());
                break;
            case 'YESTERDAY':
                $query = $query->whereDate($field_name, Carbon::yesterday());
                break;
            case 'LAST_7':
                $query = $query->whereBetween($field_name, [Carbon::now()->subDays(6), Carbon::now()]);
                break;
            case 'LAST_30':
                $query = $query->whereBetween($field_name, [Carbon::now()->subDays(29), Carbon::now()]);
                break;
            case 'THIS_WEEK':
                $query = $query->whereBetween($field_name, [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'LAST_WEEK':
                $query = $query->whereBetween($field_name, [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                break;
            case 'THIS_MONTH':
                $query = $query->whereMonth($field_name, Carbon::now()->month);
                break;
            case 'LAST_MONTH':
                $query = $query->whereMonth($field_name, Carbon::now()->subMonth()->month);
                break;
            case 'THIS_QUARTER':
                $query = $query->whereBetween($field_name, [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()]);
                break;
            case 'LAST_QUARTER':
                $query = $query->whereBetween($field_name, [Carbon::now()->subQuarter()->startOfQuarter(), Carbon::now()->subQuarter()->endOfQuarter()]);
                break;
            case 'THIS_YEAR':
                $query = $query->whereYear($field_name, Carbon::now()->year);
                break;
            case 'LAST_YEAR':
                $query = $query->whereYear($field_name, Carbon::now()->subYear()->year);
                break;
            case 'ALL_TIME':
                // No additional filtering needed
                break;
            case 'CUSTOM':
                $query = $query->whereBetween($field_name, [$from_date, $to_date]);
                break;
        }

        return $query;
    }
}
