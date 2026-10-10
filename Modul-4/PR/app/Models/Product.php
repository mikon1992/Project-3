<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_barang', 'deskripsi', 'harga', 'stok', 'gambar',
    ];

    protected function casts(): array
    {
        return ['harga' => 'decimal:2'];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Product $product) {
            if (empty($product->id_barang)) {
                $product->id_barang = 'P' . strtoupper(Str::random(6));
            }
        });
    }

    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }
}
