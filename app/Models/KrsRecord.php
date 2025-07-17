<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\JadwalTawar;
use App\Models\MatkulKurikulum;

class KrsRecord extends Model
{
    use HasFactory;
    protected $table = "krs_record";
    public $timestamps = false; // jika tidak pakai created_at / updated_at

    protected $fillable = [
        'ta',
        'kdmk',
        'id_jadwal',
        'nim_dinus',
        'sts',
        'sks',
        'modul',
        'allow_uji'
    ];

    public function jadwal_tawar(): HasOne
    {
        return $this->hasOne(JadwalTawar::class, 'id', 'id_jadwal');
    }

    public function matkul_kurikulum(): HasOne
    {
        return $this->hasOne(MatkulKurikulum::class, 'kdmk', 'kdmk');
    }
}
