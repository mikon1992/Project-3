<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function reviewedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'reviewer_id');
    }

    public function forwardings(): HasMany
    {
        return $this->hasMany(Forwarding::class, 'coordinator_id');
    }

    public function reportStatusLogs(): HasMany
    {
        return $this->hasMany(ReportStatusLog::class, 'changed_by');
    }

    public function isPelapor(): bool
    {
        return $this->role === 'pelapor';
    }

    public function isRelawan(): bool
    {
        return $this->role === 'relawan';
    }

    public function isKoordinator(): bool
    {
        return $this->role === 'koordinator';
    }
}
