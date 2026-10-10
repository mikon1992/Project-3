<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    // Tabel ini memakai primary key gabungan (id_order, id_barang) di level
    // database (lihat migration). Eloquent tidak mendukung composite key
    // secara native, jadi model ini TIDAK mengandalkan $primaryKey untuk
    // pencarian satu baris (jangan pakai find()); gunakan where() seperti
    // di OrderController atau diisi lewat relasi Order::details()->create().
    public $incrementing = false;
    protected $primaryKey = null;
    public $timestamps = false;

    protected $fillable = [
        'id_order', 'id_barang', 'harga_satuan', 'jumlah_beli',
    ];

    protected function casts(): array
    {
        return ['harga_satuan' => 'decimal:2'];
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_barang', 'id_barang');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function subtotal(): float
    {
        return $this->harga_satuan * $this->jumlah_beli;
    }
}
