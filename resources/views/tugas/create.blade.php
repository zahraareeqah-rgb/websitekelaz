@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6 pb-6">
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Tugas Baru</h1>
            <p class="text-xs text-slate-500 mt-1">Masukkan detail tugas dan tenggat waktunya.</p>
        </div>

        <form action="{{ route('tugas.store') }}" method="POST" class="space-y-4">
            @csrf
            <!-- Pilihan Guru Pengajar -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Guru Pengajar</label>
                <select name="guru_id" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Guru Pengajar --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama_guru }} ({{ $guru->mata_pelajaran ?? 'Guru' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Mata Pelajaran</label>
                <select name="mapel_id" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul Tugas</label>
                <input type="text" name="judul_tugas" value="{{ old('judul_tugas') }}" required placeholder="Contoh: Membuat Laporan Praktikum" class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deadline / Tenggat Waktu</label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status</label>
                <input type="text" name="status" value="{{ old('status', 'Aktif') }}" placeholder="Contoh: Aktif / Selesai" class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('tugas.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-semibold shadow">Simpan Tugas</button>
            </div>
        </form>
    </div>
</div>
@endsection
