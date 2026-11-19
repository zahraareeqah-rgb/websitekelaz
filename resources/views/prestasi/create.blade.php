@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6 pb-6">
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Penghargaan Kelas</h1>
            <p class="text-xs text-slate-500 mt-1">Catat prestasi atau penghargaan yang diraih oleh kelas.</p>
        </div>

        <form action="{{ route('prestasi.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Penghargaan / Lomba</label>
                <input type="text" name="nama_prestasi" required placeholder="Contoh: Juara 1 Kebersihan Antar Kelas"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kategori / Tingkat</label>
                <input type="text" name="kategori" placeholder="Contoh: Juara 1 / Finalis / Tingkat Kabupaten"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi Keterangan</label>
                <textarea name="deskripsi" rows="3" placeholder="Keterangan singkat mengenai penghargaan..."
                          class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('home') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow transition">Simpan Penghargaan</button>
            </div>
        </form>
    </div>
</div>
@endsection
