<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Mahasiswa extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = "mahasiswa_dinus";

    protected $fillable = ['nim_dinus', 'pass_mhs'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Ini wajib agar Laravel tahu password pakai pass_mhs
    public function getAuthPassword()
    {
        return $this->pass_mhs;
    }
}

