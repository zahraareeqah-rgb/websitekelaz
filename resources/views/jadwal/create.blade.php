@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 pb-6">

    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-6 md:p-8 text-white shadow-xl flex items-center justify-between">
        <div>
            <span class="bg-white/20 text-white text-[10px] font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-md">Panel Admin</span>
            <h1 class="text-2xl md:text-3xl font-bold mt-2">Tambah Jadwal Pelajaran ➕</h1>
            <p class="text-blue-100 text-xs md:text-sm mt-1">Masukkan data jadwal baru ke dalam database kelas.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-sm">
        <form action="{{ route('jadwal.store') }}" method="POST" class="space-y-5 text-xs">
            @csrf

            <!-- Pilih Mata Pelajaran -->
            <div>
                <label class="block font-bold text-slate-700 mb-1.5">Mata Pelajaran</label>
                <select name="mapel_id" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-600 transition font-medium text-slate-800">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel ?? $mapel->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Guru Pengajar -->
            <div>
                <label class="block font-bold text-slate-700 mb-1.5">Guru Pengajar</label>
                <select name="guru_id" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-600 transition font-medium text-slate-800">
                    <option value="">-- Pilih Guru Pengajar --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Hari -->
            <div>
                <label class="block font-bold text-slate-700 mb-1.5">Hari</label>
                <select name="hari" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-600 transition font-medium text-slate-800">
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                </select>
            </div>

            <!-- Jam Mulai & Selesai -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Jam Mulai (HH:MM)</label>
                    <input type="time" name="jam_mulai" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-600 transition font-medium text-slate-800">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Jam Selesai (HH:MM)</label>
                    <input type="time" name="jam_selesai" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-600 transition font-medium text-slate-800">
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('jadwal.index') }}" class="flex-1 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-2xl text-center transition">Batal</a>
                <button type="submit" class="flex-1 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-2xl shadow-lg transition">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>
@endsection
