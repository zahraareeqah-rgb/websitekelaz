@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6 pb-6">
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Data Siswa & Akun</h1>
            <p class="text-xs text-slate-500 mt-1">Masukkan biodata siswa. Akun login akan dibuatkan otomatis dengan password default: <code class="bg-slate-100 text-blue-600 px-1.5 py-0.5 rounded font-bold">12345678</code></p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-2xl text-xs space-y-1">
                <p class="font-bold">Terjadi Kesalahan:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap </label>
                <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" required placeholder="Contoh: Budi Santoso"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" required placeholder="Contoh: 0081234567"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email (Untuk Login)</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="budi@kelas.com"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Contoh: Jl. Merdeka No. 10"
                    class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Foto Profil</label>
                <input type="file" name="foto" accept="image/*"
                       class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-600">
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('home') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow transition">Simpan Siswa & Buat Akun</button>
            </div>
        </form>
    </div>
</div>
@endsection
