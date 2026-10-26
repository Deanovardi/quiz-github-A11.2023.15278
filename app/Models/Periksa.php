<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Periksa extends Model
{
    use HasFactory;

    protected $table = 'periksa';

    protected $fillable = [
        'id_daftar_poli',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
        'bukti_pembayaran',
        'status_pembayaran',
        'tgl_pembayaran',
    ];

    protected $casts = [
        'tgl_periksa' => 'datetime',
        'tgl_pembayaran' => 'datetime',
    ];

    public function daftarPoli()
    {
        return $this->belongsTo(DaftarPoli::class, 'id_daftar_poli');
    }

    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    public function obats()
    {
        return $this->belongsToMany(
            Obat::class,
            'detail_periksa',
            'id_periksa',
            'id_obat'
        );
    }
}