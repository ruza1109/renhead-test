<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalStatus;
use App\Models\Job;
use App\Models\Professor;
use App\Models\Trader;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function getStatistics(): JsonResponse
    {
        $traders = Job::join('traders', 'jobs.employee_id', '=', 'traders.id')
            ->where('jobs.employee_type', Trader::class)
            ->whereDoesntHave('approval', function ($query) {
                $query->where('status', ApprovalStatus::DISAPPROVED->value);
            })
            ->select(
                DB::raw('YEAR(jobs.date) as year'),
                DB::raw('MONTH(jobs.date) as month'),
                DB::raw('SUM(jobs.total_hours * traders.payroll_per_hour) as trader_earnings')
            )
            ->groupBy('year', 'month')
            ->get()
        ;

        $professors = Job::join('professors', 'jobs.employee_id', '=', 'professors.id')
            ->where('jobs.employee_type', Professor::class)
            ->whereDoesntHave('approval', function ($query) {
                $query->where('status', ApprovalStatus::DISAPPROVED->value);
            })
            ->select(
                DB::raw('YEAR(jobs.date) as year'),
                DB::raw('MONTH(jobs.date) as month'),
                DB::raw('SUM(jobs.total_hours * professors.payroll_per_hour) as professor_earnings')
            )
            ->groupBy('year', 'month')
            ->get()
        ;

        return response()->json([
            'traders_earnings' => $traders->groupBy(['year', 'month'])->toArray(),
            'professors_earnings' => $professors->groupBy(['year', 'month'])->toArray(),
        ]);
    }
}
