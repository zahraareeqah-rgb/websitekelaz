<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\User;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // ==========================================
    // HALAMAN DAFTAR & REKAP ABSENSI
    // ==========================================
    public function index(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer|min:2000|max:2100',
        ]);

        $bulan = (int) ($validated['bulan'] ?? now()->month);
        $tahun = (int) ($validated['tahun'] ?? now()->year);

        $tanggalAwal = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();
        $daysInMonth = $tanggalAwal->daysInMonth;

        // PERBAIKAN: Mengurutkan siswa berdasarkan nomor absen dari yang terkecil
        $siswas = Siswa::orderBy('absen', 'asc')->get();

        $absensis = Absensi::whereBetween('tanggal', [
            $tanggalAwal->toDateString(),
            $tanggalAkhir->toDateString()
        ])
        ->get()
        ->groupBy('user_id');

        return view('absensi.index', compact(
            'siswas',
            'absensis',
            'bulan',
            'tahun',
            'daysInMonth'
        ));
    }

    // ==========================================
    // UPDATE ABSENSI CEPAT (VIA TABEL MATRIKS)
    // ==========================================
    public function updateClassCepat(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $userId = $request->input('user_id');
        $tanggal = $request->input('tanggal');
        $status = $request->input('status');

        if (empty($userId) || empty($tanggal)) {
            return response()->json(['success' => false, 'message' => 'User ID atau Tanggal kosong!'], 422);
        }

        if ($status === 'Hapus' || empty($status)) {
            Absensi::where('user_id', $userId)
                ->where('tanggal', $tanggal)
                ->delete();
        } else {
            Absensi::updateOrCreate(
                [
                    'user_id' => $userId,
                    'tanggal' => $tanggal,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return response()->json(['success' => true]);
    }

    // ==========================================
    // HALAMAN TAMBAH ABSENSI
    // ==========================================
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $siswas = Siswa::orderBy('absen', 'asc')->get();
        $jadwals = Jadwal::with('mapel')->get();

        return view('absensi.create', compact('siswas', 'jadwals'));
    }

    // ==========================================
    // SIMPAN ABSENSI
    // ==========================================
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Absensi::create($validated);

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil ditambahkan.');
    }

    // ==========================================
    // HALAMAN EDIT ABSENSI
    // ==========================================
    public function edit(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $absensi = Absensi::findOrFail($id);
        $siswas = Siswa::orderBy('absen', 'asc')->get();

        return view('absensi.edit', compact('absensi', 'siswas'));
    }

    // ==========================================
    // UPDATE ABSENSI
    // ==========================================
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->update($validated);

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    // ==========================================
    // HAPUS ABSENSI
    // ==========================================
    public function destroy(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil dihapus.');
    }

    // ==========================================
    // RIWAYAT ABSENSI SISWA
    // ==========================================
    public function riwayat()
    {
        $userId = auth()->id();
        $absensis = Absensi::where('user_id', $userId)->get();

        return view('absensi.riwayat', compact('absensis'));
    }

    // ==========================================
    // REKAPITULASI ABSENSI BULANAN
    // ==========================================
    public function rekap(Request $request)
    {
        return redirect()->route('absensi.index', $request->all());
    }
    public function rekapBulan(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'tahun' => 'required',
        'bulan' => 'required',
        'status' => 'required|in:Hadir,Sakit,Izin,Alpa'
    ]);

    $userId = $request->user_id;
    $tahun = $request->tahun;
    $bulan = $request->bulan;
    $status = $request->status;

    // Hitung jumlah hari dalam bulan tersebut
    $daysInMonth = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

    for ($d = 1; $d <= $daysInMonth; $d++) {
        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $d);

        \App\Models\Absensi::updateOrCreate(
            ['user_id' => $userId, 'tanggal' => $tanggal],
            ['status' => $status]
        );
    }

    return response()->json(['success' => true]);
}
}
