<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';

    protected $fillable = [
        'mapel_id',
        'guru_id', // <-- Sudah masuk fillable
        'minggu_ke',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    // Relasi: Jadwal milik 1 Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    // 🔥 Tambahkan relasi ini: Jadwal diajar oleh 1 Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
