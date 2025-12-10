<?php

namespace App\Services;

use App\Models\VisitorLog;
use Illuminate\Support\Carbon;

class VisitorStats
{
    public static function getStats()
    {
        $now = Carbon::now();

        return [
            'online' => VisitorLog::where('visited_at', '>=', $now->copy()->subMinutes(5))->count(),

            'today'  => VisitorLog::whereDate('visited_at', $now->toDateString())->count(),

            'week'   => VisitorLog::whereBetween('visited_at', [
                            $now->copy()->startOfWeek(Carbon::MONDAY),
                            $now->copy()->endOfWeek(Carbon::SUNDAY)
                        ])->count(),

            'month'  => VisitorLog::whereYear('visited_at', $now->year)
                                  ->whereMonth('visited_at', $now->month)
                                  ->count(),

            'year'   => VisitorLog::whereYear('visited_at', $now->year)->count(),
        ];
    }
}
