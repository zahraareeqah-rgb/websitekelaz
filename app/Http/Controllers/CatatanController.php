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
        return view('catatan.index', compact('catatans'));
    }

    // Menyimpan catatan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_catatan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/catatan'), $filename);
            $fotoPath = 'uploads/catatan/' . $filename;

        }

        Catatan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi_catatan' => $request->isi_catatan,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan!');
    }

    // Menghapus catatan
    public function destroy($id)
    {
        $catatan = Catatan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($catatan->foto && file_exists(public_path($catatan->foto))) {
            unlink(public_path($catatan->foto));
        }
        $catatan->delete();


        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dihapus!');
    }
}
