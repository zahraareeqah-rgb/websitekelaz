<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    public function index()
    {
        // Ambil semua data guru dari database
        $gurus = Guru::all();
        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        // Validasi input disesuaikan dengan kolom migrasi (nama_guru & mata_pelajaran)
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'mata_pelajaran' => 'nullable|string|max:255',
        ]);

        // Simpan data guru ke database
        Guru::create($request->all());

        return redirect()->route('home')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input update
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'mata_pelajaran' => 'nullable|string|max:255',
        ]);

        // Temukan dan update data guru
        $guru = Guru::findOrFail($id);
        $guru->update($request->all());

        return redirect()->route('home')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus data guru
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('home')->with('success', 'Guru berhasil dihapus.');
    }
}
