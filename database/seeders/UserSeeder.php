<?php

namespace Database\Seeders;

use App\Models\JadwalPeriksa;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            [
                'nama_poli' => 'Poli Gigi',
                'keterangan' => 'Pemeriksaan gigi dan mulut',
                'kode_poli' => 'GIGI',
            ],
            [
                'nama_poli' => 'Poli Umum',
                'keterangan' => 'Pemeriksaan umum dan konsultasi',
                'kode_poli' => 'UMUM',
            ],
            [
                'nama_poli' => 'Poli Mata',
                'keterangan' => 'Pemeriksaan kesehatan mata',
                'kode_poli' => 'MATA',
            ],
        ];

        foreach ($polis as $poliData) {
            Poli::updateOrCreate(
                ['nama_poli' => $poliData['nama_poli']],
                $poliData
            );
        }

        $users = [
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Dokter Gigi',
                'email' => 'dokter@gmail.com',
                'password' => Hash::make('dokter'),
                'role' => 'dokter',
                'id_poli' => Poli::where('nama_poli', 'Poli Gigi')->value('id'),
            ],
            [
                'nama' => 'Dokter Umum',
                'email' => 'dokter2@gmail.com',
                'password' => Hash::make('dokter2'),
                'role' => 'dokter',
                'id_poli' => Poli::where('nama_poli', 'Poli Umum')->value('id'),
            ],
            [
                'nama' => 'Pasien',
                'email' => 'pasien@gmail.com',
                'password' => Hash::make('pasien'),
                'role' => 'pasien',
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $dokterGigi = User::where('email', 'dokter@gmail.com')->first();
        $dokterUmum = User::where('email', 'dokter2@gmail.com')->first();

        $jadwalDefaults = [
            [
                'id_dokter' => $dokterGigi?->id,
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '09:00:00',
                'current_antrian' => 0,
            ],
            [
                'id_dokter' => $dokterUmum?->id,
                'hari' => 'Selasa',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '10:00:00',
                'current_antrian' => 0,
            ],
            [
                'id_dokter' => $dokterGigi?->id,
                'hari' => 'Rabu',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '11:00:00',
                'current_antrian' => 0,
            ],
        ];

        foreach ($jadwalDefaults as $jadwal) {
            if (empty($jadwal['id_dokter'])) {
                continue;
            }

            JadwalPeriksa::updateOrCreate(
                [
                    'id_dokter' => $jadwal['id_dokter'],
                    'hari' => $jadwal['hari'],
                    'jam_mulai' => $jadwal['jam_mulai'],
                    'jam_selesai' => $jadwal['jam_selesai'],
                ],
                [
                    'current_antrian' => $jadwal['current_antrian'],
                ]
            );
        }
    }
}