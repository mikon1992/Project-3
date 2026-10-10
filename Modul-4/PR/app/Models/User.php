<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_lengkap', 'email', 'username', 'password', 'no_hp', 'alamat',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime'];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            if (empty($user->id_user)) {
                $user->id_user = 'U' . strtoupper(Str::random(6));
            }
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_user', 'id_user');
    }
}
