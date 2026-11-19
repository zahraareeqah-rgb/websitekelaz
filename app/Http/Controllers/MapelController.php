<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapels = Mapel::all();
        return view('mapels.index', compact('mapels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('mapels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Mapel::create($request->all());

        return redirect()->route('mapel.index')
            ->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $mapel = Mapel::findOrFail($id);
        return view('mapels.edit', compact('mapel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $mapel = Mapel::findOrFail($id);
        $mapel->update($request->all());

        return redirect()->route('mapel.index')
            ->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()->route('mapel.index')
            ->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}
