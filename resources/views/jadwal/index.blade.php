@extends('layouts.app')

@section('content')
<div class="space-y-6 pb-6">

    <!-- Header Banner Utama -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-6 md:p-8 text-white shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl animate-pulse"></div>
        <div class="relative z-10">
            <span class="bg-white/20 text-white text-[10px] font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-md">Portal Kelas</span>
            <h1 class="text-2xl md:text-3xl font-bold mt-2 flex items-center gap-2">
                Jadwal Pelajaran
                <span class="inline-block animate-bounce">🎓</span>
            </h1>
            <p class="text-blue-100 text-xs md:text-sm mt-1">Pilih siklus minggu dan kelola jadwal mata pelajaran kelas.</p>
        </div>

        @if(auth()->check() && auth()->user()->role === 'admin')
            <div class="relative z-10">
                <a href="{{ route('jadwal.create') }}" class="px-5 py-3 bg-white text-blue-600 hover:bg-blue-50 font-bold rounded-2xl text-xs shadow-lg transition flex items-center gap-2">
                    <span>+</span> Tambah Jadwal Baru
                </a>
            </div>
        @endif
    </div>

    <!-- Pilihan Kartu Minggu 1 - 6 (Bento Grid) -->
    <div class="space-y-3">
        <div class="flex justify-between items-center px-1">
            <h2 class="font-bold text-slate-900 text-base">Pilih Siklus Minggu Jadwal</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @for ($i = 1; $i <= 6; $i++)
                <a href="{{ route('jadwal.index', ['minggu_ke' => $i]) }}"
                   class="p-5 rounded-3xl border transition-all duration-300 flex flex-col justify-between shadow-sm relative overflow-hidden group {{ ($selectedMinggu ?? 1) == $i ? 'bg-gradient-to-br from-slate-900 to-indigo-950 text-white border-slate-900 shadow-xl scale-[1.02]' : 'bg-white text-slate-800 border-slate-200/80 hover:border-blue-400 hover:shadow-md' }}">
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-bold uppercase tracking-wider {{ ($selectedMinggu ?? 1) == $i ? 'text-blue-400' : 'text-slate-400' }}">Siklus</span>
                        </div>
                        <h3 class="font-bold text-base mt-1">Minggu ke-{{ $i }}</h3>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-[11px] font-medium {{ ($selectedMinggu ?? 1) == $i ? 'text-slate-300' : 'text-slate-500' }}">
                            {{ ($selectedMinggu ?? 1) == $i ? '● Aktif Dilihat' : 'Pilih Siklus' }}
                        </span>
                        <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs transition {{ ($selectedMinggu ?? 1) == $i ? 'bg-white/10 text-white' : 'bg-slate-100 text-slate-600 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                            →
                        </span>
                    </div>
                </a>
            @endfor
        </div>
    </div>

    <!-- Tabel Daftar Jadwal Berdasarkan Minggu yang Dipilih -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Daftar Jadwal - Minggu ke-{{ $selectedMinggu ?? 1 }}</h3>
                <p class="text-xs text-slate-500">Rincian hari, mata pelajaran, guru pengajar, dan jam kegiatan belajar mengajar.</p>
            </div>
            <span class="px-3 py-1 bg-blue-50 text-blue-600 font-semibold text-xs rounded-full border border-blue-100">
                Total: {{ count($jadwals) }} Jadwal
            </span>
        </div>

        @if(count($jadwals) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-3.5 rounded-l-xl">Hari</th>
                            <th class="p-3.5">Mata Pelajaran</th>
                            <th class="p-3.5">Guru Pengajar</th>
                            <th class="p-3.5">Waktu (Jam)</th>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <th class="p-3.5 text-right rounded-r-xl">Aksi Admin</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($jadwals as $jadwal)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-3.5 font-bold text-slate-800">{{ $jadwal->hari }}</td>
                                <td class="p-3.5 font-semibold text-blue-600">
                                    {{ $jadwal->mapel->nama_mapel ?? $jadwal->mapel->nama ?? 'Mata Pelajaran' }}
                                </td>
                                <td class="p-3.5 font-medium text-slate-700">
                                    👨‍🏫 {{ $jadwal->guru->nama_guru ?? 'Belum diatur' }}
                                </td>
                                <td class="p-3.5 font-medium text-slate-600">
                                    ⏰ {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                </td>
                                @if(auth()->check() && auth()->user()->role === 'admin')
                                    <td class="p-3.5 text-right space-x-1">
                                        <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl font-medium transition inline-block">Edit</a>
                                        <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl font-medium transition">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Tampilan Kosong yang Elegan -->
            <div class="text-center py-12 space-y-3 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto text-xl">
                    📅
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Belum ada jadwal untuk minggu ke-{{ $selectedMinggu ?? 1 }}</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Silakan tambahkan jadwal pelajaran baru melalui tombol di atas jika Anda masuk sebagai admin.</p>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="pt-2">
                        <a href="{{ route('jadwal.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow transition inline-block">
                            + Tambah Jadwal Sekarang
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>

</div>
@endsection
