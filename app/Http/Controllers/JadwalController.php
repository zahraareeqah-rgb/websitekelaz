<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Mapel;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $selectedMinggu = $request->get('minggu_ke', 1);
    $selectedHari = $request->get('hari');

    // Ambil semua jadwal pada minggu tersebut untuk perhitungan card hari
    $allJadwals = Jadwal::with(['mapel', 'guru'])->where('minggu_ke', $selectedMinggu)->get();

    // Jika hari dipilih, filter berdasarkan hari tersebut
    $jadwals = $allJadwals;
    if ($selectedHari) {
        $jadwals = $allJadwals->where('hari', $selectedHari);
    }

    return view('jadwal.index', compact('selectedMinggu', 'selectedHari', 'allJadwals', 'jadwals'));
}

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $mapels = Mapel::all();
        $gurus = \App\Models\Guru::all(); // Ambil data guru
        return view('jadwal.create', compact('mapels', 'gurus'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'nullable|exists:gurus,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $data = $request->all();
        $data['minggu_ke'] = 1; // Default value agar database tetap aman

        Jadwal::create($data);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $jadwal = Jadwal::findOrFail($id);
        $mapels = Mapel::all();
        $gurus = \App\Models\Guru::all();
        return view('jadwal.edit', compact('jadwal', 'mapels', 'gurus'));
    }

    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'nullable|exists:gurus,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }
    public function destroy($id)
{
    $jadwal = \App\Models\Jadwal::findOrFail($id);
    $jadwal->delete();

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
}
}
