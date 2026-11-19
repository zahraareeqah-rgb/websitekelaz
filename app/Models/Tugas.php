<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'mapel_id',
        'guru_id',
        'judul_tugas',
        'deskripsi',
        'deadline',
        'status',
    ];

    // Relasi: Tugas milik 1 Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
    public function guru()
{
    return $this->belongsTo(Guru::class, 'guru_id');
}
}
