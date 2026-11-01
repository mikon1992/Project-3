<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecapController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'area_id' => ['nullable', 'integer', 'exists:areas,id'],
            'status' => ['nullable', 'in:submitted,under_review,flagged,forwarded,closed'],
        ]);

        $query = Report::query()->with('forwarding')->when(
            $filters['area_id'] ?? null,
            fn ($builder, $areaId) => $builder->where('area_id', $areaId),
        )->when(
            $filters['status'] ?? null,
            fn ($builder, $status) => $builder->where('status', $status),
        );

        $reports = $query->get();
        $grouped = $reports->groupBy('area_id');
        $areas = Area::query()
            ->when($filters['area_id'] ?? null, fn ($builder, $areaId) => $builder->whereKey($areaId))
            ->orderBy('name')
            ->get();

        $rows = $areas->map(function (Area $area) use ($grouped) {
            $items = $grouped->get($area->id, collect());

            return [
                'area' => $area,
                'total' => $items->count(),
                'submitted' => $items->where('status', 'submitted')->count(),
                'under_review' => $items->where('status', 'under_review')->count(),
                'flagged' => $items->where('status', 'flagged')->count(),
                'forwarded' => $items->where('status', 'forwarded')->count(),
                'closed' => $items->where('status', 'closed')->count(),
            ];
        });

        $summary = [
            'total' => $reports->count(),
            'active' => $reports->where('status', '!=', 'closed')->count(),
            'closed' => $reports->where('status', 'closed')->count(),
            'forwarded' => $reports->filter(fn ($report) => $report->forwarding !== null)->count(),
        ];
        $filterAreas = Area::query()->where('is_active', true)->orderBy('name')->get();

        return view('reports.recap', compact('areas', 'filterAreas', 'filters', 'rows', 'summary'));
    }
}
