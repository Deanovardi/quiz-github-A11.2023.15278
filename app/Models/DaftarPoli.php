<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DaftarPoli extends Model
{
    use HasFactory;

    protected $table = 'daftar_poli';

    protected $fillable = [
        'id_pasien',
        'id_jadwal',
        'keluhan',
        'no_antrian',
    ];

    protected $appends = ['nomor_antrian_format'];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function jadwalPeriksa()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');
    }

    public function periksa()
    {
        return $this->hasOne(Periksa::class, 'id_daftar_poli');
    }

    public function getNomorAntrianFormatAttribute()
    {
        $kodePoli = $this->jadwalPeriksa?->dokter?->poli?->kode_poli ?? 'A';
        return $kodePoli . '-' . $this->no_antrian;
    }
}