<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $tugas = Tugas::with(['mapel', 'guru'])->orderBy('deadline', 'asc')->get();
        return view('tugas.index', compact('tugas'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $mapels = Mapel::all();$gurus = Guru::all();
        return view('tugas.create', compact('mapels', 'gurus'));
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
        $mapels = Mapel::all();$gurus = Guru::all();
        return view('tugas.edit', compact('tugas', 'mapels', 'gurus'));
    }

    public function update(Request $request, string$id)
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

        $tugasItem = Tugas::findOrFail($id);
        $tugasItem->update($request->all());

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $tugas = Tugas::findOrFail($id);$tugas->delete();

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
