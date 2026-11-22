@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6 pb-6">
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Guru Pengajar</h1>
            <p class="text-xs text-slate-500 mt-1">Masukkan nama guru dan pilih mata pelajaran yang diampu.</p>
        </div>

        <form action="{{ route('guru.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Guru -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Guru & Gelar</label>
                <input type="text" name="nama_guru" required placeholder="Contoh: Dra. Hj. Siti Aminah"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <!-- Mata Pelajaran (Dropdown dari Tabel Mapel) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Mata Pelajaran</label>
                <select name="mapel_id" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                    @foreach($mapels as $mapel)
                        <!-- Sesuaikan value dengan id atau nama mapel di database kamu -->
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('home') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow transition">Simpan Guru</button>
            </div>
        </form>
    </div>
</div>
@endsection