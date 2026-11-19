<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasis = Prestasi::all();
        return view('prestasi.index', compact('prestasis'));
    }

    public function create()
    {
        return view('prestasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Prestasi::create($request->all());

        return redirect()->route('home')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        return view('prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $prestasi = Prestasi::findOrFail($id);
        $prestasi->update($request->all());

        return redirect()->route('home')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->delete();

        return redirect()->route('home')->with('success', 'Prestasi berhasil dihapus.');
    }
}
