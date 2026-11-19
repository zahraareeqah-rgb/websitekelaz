<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\Tugas;
use App\Models\Absensi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun Admin (untuk login sebagai pengurus kelas)
        $admin = User::create([
            'name' => 'Admin Kelas',
            'email' => 'admin@kelas.com',
            'password' => Hash::make('password'), // Password-nya: password
            'role' => 'admin',
        ]);

        // 2. Membuat Akun Siswa (untuk login sebagai siswa)
        $siswa1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@siswa.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        $siswa2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@siswa.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        // 3. Membuat Data Mata Pelajaran
        $mapelMatematika = Mapel::create([
            'nama_mapel' => 'Matematika Lanjut',
            'keterangan' => 'Ilmu...',
        ]);

        $mapelPwl = Mapel::create([
            'nama_mapel' => 'Pemrograman Web',
            'keterangan' => 'Ilmu...',
        ]);

        // 4. Membuat Contoh Jadwal (Sistem Siklus Minggu ke-1)
        Jadwal::create([
            'mapel_id' => $mapelMatematika->id,
            'minggu_ke' => 1,
            'hari' => 'Senin',
            'jam_mulai' => '07:30',
            'jam_selesai' => '09:00',
        ]);

        Jadwal::create([
            'mapel_id' => $mapelPwl->id,
            'minggu_ke' => 1,
            'hari' => 'Selasa',
            'jam_mulai' => '09:15',
            'jam_selesai' => '11:30',
        ]);

        // 5. Membuat Contoh Tugas Kelas
        Tugas::create([
            'mapel_id' => $mapelPwl->id,
            'judul_tugas' => 'Membuat Layout Tailwind',
            'deskripsi' => 'Buat halaman portal kelas dengan grid sederhana.',
            'deadline' => now()->addDays(3),
            'status' => 'Belum',
        ]);

        // 6. Membuat Contoh Absensi Siswa
        Absensi::create([
            'user_id' => $siswa1->id,
            'tanggal' => now()->format('Y-m-d'),
            'status' => 'Hadir',
            'keterangan' => 'Tepat waktu',
        ]);
    }
}
