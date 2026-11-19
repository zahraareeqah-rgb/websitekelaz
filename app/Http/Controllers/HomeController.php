<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Support\Facades\Hash; // Wajib ada untuk mengecek dan mengenkripsi password

class HomeController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        $prestasis = Prestasi::all();

        $siswas = Siswa::orderBy('absen', 'asc')->get();

        $tugasList = Tugas::with('mapel')->get(); // Mengurutkan siswa berdasarkan nama
        return view('home', compact('gurus', 'prestasis', 'siswas', 'tugasList'));
    }

    // --- TAMBAHKAN KODE INI DI BAWAHNYA ---

    public function editPassword()
    {
        return view('auth.ganti-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai!']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('home')->with('success', 'Password berhasil diperbarui!');
    }
}
