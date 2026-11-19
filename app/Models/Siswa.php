<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $fillable = [
        'user_id',
        'nama_siswa',
        'nisn',
        'email',
        'absen',
        'alamat',        // Menggantikan 'kelas'
        'jenis_kelamin', // Kolom baru jenis kelamin
        'foto',
    ];

    // Relasi ke User (Login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
