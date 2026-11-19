<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Mapel;
use App\Models\Guru; // 1. Tambahkan import Model Guru di sini
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        // Sertakan relasi 'mapel' dan 'guru' agar data terkait ikut terpanggil
        $tugas = Tugas::with(['mapel', 'guru'])->get();
        return view('tugas.index', compact('tugas'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $mapels = Mapel::all();
        $gurus = Guru::all(); // 2. Ambil data guru
        return view('tugas.create', compact('mapels', 'gurus')); // 3. Kirim ke view
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'nullable|exists:gurus,id',
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date',
            'status' => 'nullable|string',
        ]);

        Tugas::create($request->all());

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $tugas = Tugas::findOrFail($id);
        $mapels = Mapel::all();
        $gurus = Guru::all(); // 4. Ambil data guru untuk form edit
        return view('tugas.edit', compact('tugas', 'mapels', 'gurus')); // 5. Kirim ke view
    }

    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'nullable|exists:gurus,id',
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date',
            'status' => 'nullable|string',
        ]);

        $tugas = Tugas::findOrFail($id);
        $tugas->update($request->all());

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $tugas = Tugas::findOrFail($id);
        $tugas->delete();

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
