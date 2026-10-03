<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'code',
        'title',
        'description',
        'start_at',
        'end_at',
        'location',
        'capacity',
        'poster_path',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'capacity' => 'integer',
        'registered_count' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('code', 'like', "%{$keyword}%");
            });
        });
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->when($categoryId, fn ($query, $id) =>
            $query->where('category_id', $id)
        );
    }

    public function scopeByStatus($query, ?string $status)
    {
        return $query->when($status, fn ($query, $status) =>
            $query->where('status', $status)
        );
    }

    public function scopeSortByStartAt($query, ?string $sort)
    {
        $direction = $sort === 'oldest' ? 'asc' : 'desc';

        return $query->orderBy('start_at', $direction);
    }
    
}
