<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Forwarding;
use App\Services\ReportStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ForwardingController extends Controller
{
    public function store(Request $request, Report $report): RedirectResponse
    {
        Gate::authorize('forward', $report);

        $data = $request->validate([
            'forwarded_to' => ['required', 'string', 'max:120'],
            'note' => ['nullable', 'string', 'max:3000'],
        ]);

        DB::transaction(function () use ($report, $data) {
            Forwarding::create([
                'report_id' => $report->id,
                'coordinator_id' => auth()->id(),
                'forwarded_to' => $data['forwarded_to'],
                'note' => $data['note'] ?? null,
                'forwarded_at' => now(),
            ]);

            app(ReportStatusService::class)->change($report, 'forwarded');
        });

        return back()->with('success', 'Penerusan informasi berhasil dicatat.');
    }

    public function close(Report $report): RedirectResponse
    {
        Gate::authorize('close', $report);
        app(ReportStatusService::class)->change($report, 'closed');

        return back()->with('success', 'Proses laporan komunitas telah ditutup.');
    }
}