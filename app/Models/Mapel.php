<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapels';

    protected $fillable = [
        'nama_mapel',
        'keterangan',
    ];

    // Relasi: 1 Mapel punya banyak Jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    // Relasi: 1 Mapel punya banyak Tugas
    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
