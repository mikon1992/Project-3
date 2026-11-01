<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReportStatusService
{
    private const TRANSITIONS = [
        'submitted' => ['under_review'],
        'under_review' => ['flagged', 'closed'],
        'flagged' => ['forwarded'],
        'forwarded' => ['closed'],
        'closed' => [],
    ];

    public function change(Report $report, string $newStatus): void
    {
        if (! in_array($newStatus, self::TRANSITIONS[$report->status] ?? [], true)) {
            throw ValidationException::withMessages([
                'status' => 'Perubahan status tidak sesuai alur laporan.',
            ]);
        }

        if ($newStatus === 'flagged' && (! $report->reviewer_id || blank($report->review_note))) {
            throw ValidationException::withMessages([
                'review_note' => 'Laporan harus ditinjau dan memiliki catatan sebelum ditandai perlu diteruskan.',
            ]);
        }

        DB::transaction(function () use ($report, $newStatus) {
            $report->status = $newStatus;
            $report->save();
        });
    }
}