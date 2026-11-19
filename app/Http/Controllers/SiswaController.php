<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        // Menampilkan siswa urut berdasarkan nomor absen
        $siswas = Siswa::orderBy('absen', 'asc')->get();
        return view('siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswas,nisn',
            'email' => 'required|email|unique:siswas,email|unique:users,email',
            'alamat' => 'nullable|string',                  // Disesuaikan dari kelas ke alamat
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', // Validasi jenis kelamin
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // 1. Handle Upload Foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/siswa'), $filename);
            $data['foto'] = 'uploads/siswa/' . $filename;
        }

        // 2. Otomatis buatkan Akun Login di tabel `users`
        $user = User::create([
            'name' => $request->nama_siswa,
            'email' => $request->email,
            'password' => Hash::make('12345678'), // Password default
            'role' => 'siswa',
        ]);

        // 3. Masukkan user_id ke data siswa
        $data['user_id'] = $user->id;

        // 4. Simpan data siswa (absen akan otomatis diatur di bawah)
        Siswa::create($data);

        // 5. OTOMATIS RAPIKAN URUTAN ABSEN BERDASARKAN ABJAD NAMA
        $semuaSiswa = Siswa::orderBy('nama_siswa', 'asc')->get();
        foreach ($semuaSiswa as $index => $siswaItem) {
            $siswaItem->update(['absen' => $index + 1]);
        }

        return redirect()->route('home')->with('success', 'Siswa berhasil ditambahkan dan nomor absen diurutkan otomatis sesuai abjad!');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswas,nisn,' . $id,
            'email' => 'required|email|unique:siswas,email,' . $id,
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Handle Update Foto
        if ($request->hasFile('foto')) {
            if ($siswa->foto && file_exists(public_path($siswa->foto))) {
                unlink(public_path($siswa->foto));
            }
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/siswa'), $filename);
            $data['foto'] = 'uploads/siswa/' . $filename;
        }

        $siswa->update($data);

        // Update juga nama/email di tabel users jika terhubung
        if ($siswa->user_id) {
            $user = User::find($siswa->user_id);
            if ($user) {
                $user->update([
                    'name' => $request->nama_siswa,
                    'email' => $request->email,
                ]);
            }
        }

        // Rapikan ulang urutan absen berdasarkan abjad nama setelah update
        $semuaSiswa = Siswa::orderBy('nama_siswa', 'asc')->get();
        foreach ($semuaSiswa as $index => $siswaItem) {
            $siswaItem->update(['absen' => $index + 1]);
        }

        return redirect()->route('home')->with('success', 'Data siswa berhasil diperbarui dan disesuaikan urutannya.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus foto jika ada
        if ($siswa->foto && file_exists(public_path($siswa->foto))) {
            unlink(public_path($siswa->foto));
        }

        // Hapus juga akun user-nya jika ada
        if ($siswa->user_id) {
            User::where('id', $siswa->user_id)->delete();
        }

        $siswa->delete();

        // Rapikan kembali nomor absen siswa yang tersisa berdasarkan abjad nama
        $semuaSiswa = Siswa::orderBy('nama_siswa', 'asc')->get();
        foreach ($semuaSiswa as $index => $siswaItem) {
            $siswaItem->update(['absen' => $index + 1]);
        }

        return redirect()->route('home')->with('success', 'Siswa berhasil dihapus dan nomor absen disesuaikan kembali.');
    }
}
