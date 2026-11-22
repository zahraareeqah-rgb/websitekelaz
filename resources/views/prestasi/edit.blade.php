@extends('layouts.app')

@section('content')
<!-- Container Utama Fullscreen dengan Background Papan Tulis Kelas -->
<div class="relative min-h-screen -m-6 p-6 md:p-12 bg-cover bg-center bg-fixed text-slate-800 font-sans flex flex-col justify-between overflow-x-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');">

    <!-- Overlay Gelap Tipis -->
    <div class="absolute inset-0 bg-slate-950/45 backdrop-blur-[1px] z-0"></div>

    <!-- WRAPPER UTAMA -->
    <div class="relative z-10 w-full max-w-xl mx-auto space-y-8 pt-4 pb-16">

        <!-- CARD FORM EDIT PRESTASI -->
        <div class="bg-white rounded-[2.5rem] p-6 md:p-8 border border-slate-200/80 shadow-2xl space-y-6 relative overflow-hidden">
            
            <!-- Header Form -->
            <div class="space-y-1 border-b border-slate-100 pb-5 relative z-10">
                <span class="text-[10px] bg-amber-100 text-amber-700 font-extrabold px-3 py-1 rounded-full border border-amber-200 uppercase tracking-widest inline-block mb-2">
                    🏆 Manajemen Penghargaan
                </span>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Edit Penghargaan Kelas</h1>
                <p class="text-xs text-slate-500">Perbarui informasi prestasi atau penghargaan yang diraih oleh kelas.</p>
            </div>

            <!-- Tampilkan Error Validasi Jika Ada -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-2xl text-xs space-y-1 relative z-10">
                    <p class="font-bold">Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Update Prestasi -->
            <form action="{{ route('prestasi.update', $prestasi->id) }}" method="POST" class="space-y-5 relative z-10">
                @csrf
                @method('PUT')

                <!-- Nama Penghargaan -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Penghargaan / Lomba</label>
                    <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi', $prestasi->nama_prestasi ?? $prestasi->judul ?? $prestasi->nama) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-amber-500 transition"
                           placeholder="Contoh: Juara 1 Kebersihan Antar Kelas">
                </div>

                <!-- Kategori / Tingkat -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kategori / Tingkat</label>
                    <input type="text" name="kategori" value="{{ old('kategori', $prestasi->kategori ?? $prestasi->tingkat ?? '') }}"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-amber-500 transition"
                           placeholder="Contoh: Juara 1 / Finalis / Tingkat Kabupaten">
                </div>

                <!-- Deskripsi Keterangan (Otomatis Menampilkan Data yang Sudah Ada) -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi Keterangan</label>
                    <textarea name="deskripsi" rows="3"
                              class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-amber-500 transition"
                              placeholder="Keterangan singkat mengenai penghargaan...">{{ old('deskripsi', $prestasi->deskripsi ?? $prestasi->keterangan ?? '') }}</textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('home') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl text-xs font-bold transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold rounded-2xl text-xs shadow-md transition uppercase tracking-wider">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection