<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga',
        'stok',
    ];

    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_obat');
    }

    public function periksas()
    {
        return $this->belongsToMany(
            Periksa::class,
            'detail_periksa',
            'id_obat',
            'id_periksa'
        );
    }
}