<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catatan;
use Illuminate\Support\Facades\Auth;

class CatatanController extends Controller
{
    // Menampilkan daftar catatan milik user yang sedang login
    public function index()
    {
        $catatans = Catatan::where('user_id', Auth::id())->latest()->get();
        
        // Ubah string JSON foto kembali menjadi array agar mudah dibaca di view
        foreach ($catatans as $catatan) {
            if (!empty($catatan->foto)) {
                $decoded = json_decode($catatan->foto, true);
                $catatan->foto = is_array($decoded) ? $decoded : [$catatan->foto];
            } else {
                $catatan->foto = [];
            }
        }

        return view('catatan.index', compact('catatans'));
    }

    // Menyimpan catatan baru ke database (Mendukung Banyak Foto)
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_catatan' => 'required|string',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk setiap file dalam array
        ]);

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/catatan'), $filename);
                $fotoPaths[] = 'uploads/catatan/' . $filename;
            }
        }

        Catatan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi_catatan' => $request->isi_catatan,
            'foto' => !empty($fotoPaths) ? json_encode($fotoPaths) : null, // Simpan array path foto sebagai JSON
        ]);

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $catatan = Catatan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if (!empty($catatan->foto)) {
            $decoded = json_decode($catatan->foto, true);
            $catatan->foto = is_array($decoded) ? $decoded : [$catatan->foto];
        } else {
            $catatan->foto = [];
        }

        return view('catatan.edit', compact('catatan'));
    }

    public function update(Request $request, $id)
{
    $catatan = Catatan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    $request->validate([
        'judul' => 'required|string|max:255',
        'isi_catatan' => 'required|string',
        'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'hapus_foto.*' => 'nullable|string',
        'ganti_foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = [
        'judul' => $request->judul,
        'isi_catatan' => $request->isi_catatan,
    ];

    // 1. Ambil foto lama
    $fotoPaths = [];
    if (!empty($catatan->foto)) {
        $decoded = json_decode($catatan->foto, true);
        $fotoPaths = is_array($decoded) ? $decoded : [$catatan->foto];
    }

    // 2. Tangani Penghapusan Foto yang dicentang
    if ($request->has('hapus_foto')) {
        $fotoDihapus = $request->input('hapus_foto');
        $fotoPaths = array_filter($fotoPaths, function($path) use ($fotoDihapus) {
            if (in_array($path, $fotoDihapus)) {
                if (file_exists(public_path($path))) {
                    @unlink(public_path($path));
                }
                return false;
            }
            return true;
        });
        $fotoPaths = array_values($fotoPaths);
    }

    // 3. Tangani Penggantian (Replace) Foto Berdasarkan Index-nya
    if ($request->hasFile('ganti_foto')) {
        foreach ($request->file('ganti_foto') as $index => $file) {
            if (isset($fotoPaths[$index])) {
                // Hapus file fisik lama
                if (file_exists(public_path($fotoPaths[$index]))) {
                    @unlink(public_path($fotoPaths[$index]));
                }
                
                // Upload file pengganti baru
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/catatan'), $filename);
                
                // Timpa path lama dengan path baru pada index yang sama
                $fotoPaths[$index] = 'uploads/catatan/' . $filename;
            }
        }
    }

    // 4. Tambah foto baru jika ada tambahan di bawahnya (opsional)
    if ($request->hasFile('foto')) {
        foreach ($request->file('foto') as $file) {
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/catatan'), $filename);
            $fotoPaths[] = 'uploads/catatan/' . $filename;
        }
    }

    $data['foto'] = !empty($fotoPaths) ? json_encode($fotoPaths) : null;
    $catatan->update($data);

    return redirect()->route('catatan.index')->with('success', 'Catatan berhasil diperbarui!');
}

    // Menghapus catatan beserta seluruh file foto lampirannya
    public function destroy($id)
    {
        $catatan = Catatan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if (!empty($catatan->foto)) {
            $decoded = json_decode($catatan->foto, true);
            $fotos = is_array($decoded) ? $decoded : [$catatan->foto];
            
            foreach ($fotos as $f) {
                if (file_exists(public_path($f))) {
                    @unlink(public_path($f));
                }
            }
        }
        
        $catatan->delete();

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dihapus!');
    }
}