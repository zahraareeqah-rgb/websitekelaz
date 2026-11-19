@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6 pb-6">
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Absensi Baru</h1>
            <p class="text-xs text-slate-500 mt-1">Catat kehadiran member kelas.</p>
        </div>

        <form action="{{ route('absensi.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pilih Siswa / User</label>
                <select name="user_id" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $siswa)
                        {{-- Asumsi tabel users / siswas terhubung melalui email atau id akun --}}
                        @php
                            $user = \App\Models\User::where('email', $siswa->email)->first();
                        @endphp
                        @if($user)
                            <option value="{{ $user->id }}">{{ $siswa->nama_siswa }} (Absen: {{ $siswa->absen }})</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Kehadiran</label>
                <select name="status" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Alpa">Alpa</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3" placeholder="Contoh: Surat dokter terlampir..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-800 focus:outline-none focus:border-blue-500">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('absensi.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-semibold shadow">Simpan Absensi</button>
            </div>
        </form>
    </div>
</div>
@endsection
