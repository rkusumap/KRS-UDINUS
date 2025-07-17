<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\MatkulKurikulum;

class JadwalTawar extends Model
{
    use HasFactory;
    protected $table = "jadwal_tawar";
    public $timestamps = false; // jika tidak pakai created_at / updated_at

    public function matkul_kurikulum(): HasOne
    {
        return $this->hasOne(MatkulKurikulum::class, 'kdmk', 'kdmk');
    }
}
