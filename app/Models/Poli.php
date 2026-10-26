<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'poli';

    protected $fillable = [
        'nama_poli',
        'keterangan',
        'tarif',
        'kode_poli',
    ];

    // Relasi dokter ke poli
    public function dokters()
    {
        return $this->hasMany(User::class, 'id_poli')
                    ->where('role', 'dokter');
    }
}