@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 pb-6">
    <!-- Banner Header Form -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden flex justify-between items-center">
        <div class="relative z-10">
            <span class="bg-white/20 text-white text-[10px] font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-md">Panel Admin</span>
            <h1 class="text-2xl font-bold mt-2">Edit Jadwal Pelajaran</h1>
            <p class="text-blue-100 text-xs mt-1">Perbarui data jadwal pelajaran kelas di database.</p>
        </div>
    </div>

    <!-- Form Edit Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-sm space-y-6">
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

        <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Pilih Mata Pelajaran (Relasi) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Mata Pelajaran</label>
                <select name="mapel_id" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach(\App\Models\Mapel::all() as $mapel)
                        <option value="{{ $mapel->id }}" {{ (old('mapel_id', $jadwal->mapel_id) == $mapel->id) ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel ?? $mapel->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Guru Pengajar (Relasi) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Guru Pengajar</label>
                <select name="guru_id"
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Guru Pengajar --</option>
                    @foreach(\App\Models\Guru::all() as $guru)
                        <option value="{{ $guru->id }}" {{ (old('guru_id', $jadwal->guru_id) == $guru->id) ? 'selected' : '' }}>
                            {{ $guru->nama_guru }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Hari -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Hari</label>
                <select name="hari" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="Senin" {{ (old('hari', $jadwal->hari) == 'Senin') ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ (old('hari', $jadwal->hari) == 'Selasa') ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ (old('hari', $jadwal->hari) == 'Rabu') ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ (old('hari', $jadwal->hari) == 'Kamis') ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ (old('hari', $jadwal->hari) == 'Jumat') ? 'selected' : '' }}>Jumat</option>
                </select>
            </div>

            <!-- Jam Mulai & Jam Selesai -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" required
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('jadwal.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
