<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['pelapor', 'relawan', 'koordinator'], true);
    }

    public function view(User $user, Report $report): bool
    {
        return $user->isRelawan() || $user->isKoordinator() || ($user->isPelapor() && $report->user_id === $user->id);
    }

    public function create(User $user): bool
    {
        return $user->isPelapor();
    }

    public function update(User $user, Report $report): bool
    {
        return $user->isPelapor() && $report->user_id === $user->id && $report->status === 'submitted';
    }

    public function delete(User $user, Report $report): bool
    {
        return $user->isPelapor() && $report->user_id === $user->id && $report->status === 'submitted';
    }

    public function review(User $user, Report $report): bool
    {
        return $user->isRelawan() && in_array($report->status, ['submitted', 'under_review'], true);
    }

    public function forward(User $user, Report $report): bool
    {
        return $user->isKoordinator() && $report->status === 'flagged' && ! $report->forwarding()->exists();
    }

    public function close(User $user, Report $report): bool
    {
        return ($user->isRelawan() && $report->status === 'under_review') || ($user->isKoordinator() && $report->status === 'forwarded');
    }
}