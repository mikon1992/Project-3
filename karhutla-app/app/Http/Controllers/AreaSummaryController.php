<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Support\Facades\Auth;

class AreaSummaryController extends Controller
{
    public function show(Area $area)
    {
        abort_unless($area->is_active, 404);

        $activeReports = $area->reports()->where('status', '!=', 'closed');
        $severityCounts = [
            'ringan' => (clone $activeReports)->where('severity', 'ringan')->count(),
            'sedang' => (clone $activeReports)->where('severity', 'sedang')->count(),
            'berat' => (clone $activeReports)->where('severity', 'berat')->count(),
        ];
        $latest = (clone $activeReports)->latest()->take(3)->get(['id', 'title', 'status', 'occurred_at']);

        if (Auth::user()->isPelapor()) {
            $latest->each(function ($report) {
                $report->title = 'Laporan warga';
            });
        }

        return response()->json([
            'area' => $area->name,
            'active_count' => (clone $activeReports)->count(),
            'severity_counts' => $severityCounts,
            'latest_reports' => $latest->map(fn ($report) => [
                'title' => $report->title,
                'status' => $report->status,
                'occurred_at' => $report->occurred_at,
            ]),
        ]);
    }
}