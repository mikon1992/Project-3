<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user', 'tanggal_order', 'total_harga', 'alamat_pengiriman',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_order' => 'datetime',
            'total_harga' => 'decimal:2',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Order $order) {
            if (empty($order->id_order)) {
                $order->id_order = 'O' . now()->format('ymdHis') . strtoupper(Str::random(3));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
}
