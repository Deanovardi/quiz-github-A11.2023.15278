<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalPeriksa extends Model
{
    use HasFactory;

    protected $table = 'jadwal_periksa';

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'current_antrian',
    ];

    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    public function daftarPolis()
    {
        return $this->hasMany(DaftarPoli::class, 'id_jadwal');
    }
}