@extends('layouts.app')

@section('content')
<!-- Container Utama Fullscreen dengan Background Papan Tulis Kelas -->
<div class="relative min-h-screen -m-6 p-6 md:p-12 bg-cover bg-center bg-fixed text-white font-sans flex flex-col justify-between overflow-x-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');">

    <div class="absolute inset-0 bg-slate-950/45 backdrop-blur-[1px] z-0"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto space-y-10 pt-4 pb-16">

        <!-- ================= HERO SECTION ================= -->
        <div class="text-center space-y-4 max-w-3xl mx-auto pt-6">
            <div class="inline-flex items-center space-x-2 text-emerald-300 font-semibold text-xs tracking-widest uppercase bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20 shadow-lg">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Portal Resmi • XI RPL 1</span>
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white leading-none drop-shadow-2xl">
                JADWAL KELAS <br>
            </h1>

            <p class="text-slate-200 text-sm sm:text-base leading-relaxed max-w-lg mx-auto drop-shadow font-medium">
                Pilih siklus minggu pembelajaran, lalu klik hari yang diinginkan untuk melihat rincian jadwal mata pelajaran.
            </p>
        </div>

        <!-- ================= BAR PENCARIAN / SIKLUS MINGGU ================= -->
        <div class="bg-slate-900/65 backdrop-blur-2xl rounded-3xl p-4 md:p-6 border border-white/20 shadow-2xl max-w-5xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-4 px-2">
                <div>
                    <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider">Navigasi Siklus</span>
                    <h3 class="text-white font-bold text-base">Pilih Minggu Pembelajaran</h3>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('jadwal.create') }}" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl shadow-lg transition text-xs tracking-wider uppercase">
                        + Tambah Jadwal Baru
                    </a>
                @endif
            </div>

            <!-- Grid Pilihan Minggu (1 - 6) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                @for ($i = 1; $i <= 6; $i++)
                    <a href="{{ route('jadwal.index', ['minggu_ke' => $i]) }}"
                       class="p-4 rounded-2xl border transition-all duration-300 flex flex-col justify-between shadow-sm relative overflow-hidden group {{ ($selectedMinggu ?? 1) == $i ? 'bg-emerald-500 text-slate-950 border-emerald-400 font-extrabold shadow-lg scale-105' : 'bg-white/10 text-slate-200 border-white/15 hover:bg-white/20' }}">
                        <div>
                            <span class="text-[9px] uppercase tracking-wider opacity-75">Siklus</span>
                            <h4 class="text-sm font-bold mt-0.5">Minggu ke-{{ $i }}</h4>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-[11px]">
                            <span class="font-medium">{{ ($selectedMinggu ?? 1) == $i ? '● Aktif' : 'Pilih' }}</span>
                            <span class="text-xs">→</span>
                        </div>
                    </a>
                @endfor
            </div>
        </div>

        <!-- ================= KONDISI 1: JIKA BELUM PILIH HARI (TAMPILKAN CARD HARI) ================= -->
        @php
            $selectedHari = request('hari');
            $daftarHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        @endphp

        @if(!$selectedHari)
            <div class="space-y-6 max-w-5xl mx-auto">
                <div class="bg-slate-900/65 backdrop-blur-2xl rounded-3xl p-6 border border-white/20 shadow-xl flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-white text-lg">Pilih Hari - Minggu ke-{{ $selectedMinggu ?? 1 }}</h3>
                        <p class="text-xs text-slate-300">Silakan pilih salah satu hari di bawah ini untuk melihat jadwal pelajarannya.</p>
                    </div>
                </div>

                <!-- Grid Card Hari -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($daftarHari as $hari)
                        @php
                            // Hitung jumlah jadwal di hari tersebut untuk minggu ini
                            $jumlahJadwalHari = $allJadwals->where('minggu_ke', $selectedMinggu ?? 1)->where('hari', $hari)->count();
                        @endphp
                        <a href="{{ route('jadwal.index', ['minggu_ke' => $selectedMinggu ?? 1, 'hari' => $hari]) }}"
                           class="bg-slate-900/80 hover:bg-slate-800/90 backdrop-blur-xl border border-white/15 hover:border-emerald-400 rounded-3xl p-6 shadow-2xl transition-all duration-300 flex flex-col justify-between group">
                            <div class="flex items-center justify-between">
                                <span class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 flex items-center justify-center text-xl font-black group-hover:scale-110 transition">
                                    🗓️
                                </span>
                                <span class="px-3 py-1 bg-white/10 text-slate-300 text-xs font-bold rounded-xl border border-white/10">
                                    {{ $jumlahJadwalHari }} Mapel
                                </span>
                            </div>
                            <div class="mt-6">
                                <h4 class="text-xl font-black text-white group-hover:text-emerald-300 transition">{{ $hari }}</h4>
                                <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                                    <span>Klik untuk lihat detail jadwal</span>
                                    <span class="group-hover:translate-x-1 transition">→</span>
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        <!-- ================= KONDISI 2: JIKA HARI SUDAH DIPILIH (TAMPILKAN TABEL JADWAL) ================= -->
        @else
            <div class="bg-slate-900/65 backdrop-blur-2xl rounded-3xl p-6 md:p-8 border border-white/20 shadow-2xl space-y-6 max-w-6xl mx-auto">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/10 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('jadwal.index', ['minggu_ke' => $selectedMinggu ?? 1]) }}" class="px-3 py-1 bg-white/10 hover:bg-white/20 rounded-xl text-xs text-slate-300 transition">
                                ← Kembali ke Pilih Hari
                            </a>
                            <span class="text-xs text-emerald-400 font-bold uppercase tracking-wider">• Minggu ke-{{ $selectedMinggu ?? 1 }}</span>
                        </div>
                        <h3 class="font-black text-white text-2xl mt-2">Jadwal Hari {{ $selectedHari }}</h3>
                    </div>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('jadwal.create') }}" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold rounded-xl text-xs shadow transition">
                            + Tambah Jadwal
                        </a>
                    @endif
                </div>

                @if(count($jadwals) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-200">
                            <thead class="bg-white/10 text-slate-300 uppercase tracking-wider border-b border-white/15">
                                `<tr>
                                    <th class="p-4 rounded-l-2xl">Jam Pelajaran</th>
                                    <th class="p-4">Mata Pelajaran</th>
                                    <th class="p-4">Guru Pengajar</th>
                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                        <th class="p-4 text-right rounded-r-2xl">Aksi Admin</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($jadwals as $jadwal)
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="p-4 font-bold text-emerald-300 text-sm">
                                            ⏰ {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                                        </td>
                                        <td class="p-4 font-bold text-white text-sm">
                                            {{ $jadwal->mapel->nama_mapel ?? $jadwal->mapel->nama ?? 'Mata Pelajaran' }}
                                        </td>
                                        <td class="p-4 font-medium text-slate-200">
                                            👨‍🏫 {{ $jadwal->guru->nama_guru ?? 'Belum diatur' }}
                                        </td>
                                        @if(auth()->check() && auth()->user()->role === 'admin')
                                            <td class="p-4 text-right space-x-1">
                                                <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="px-3 py-1.5 bg-amber-500/20 text-amber-300 border border-amber-400/30 hover:bg-amber-500/30 rounded-xl font-medium transition inline-block">Edit</a>
                                                <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-red-500/20 text-red-300 border border-red-400/30 hover:bg-red-500/30 rounded-xl font-medium transition">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12 space-y-3 bg-white/5 rounded-3xl border border-dashed border-white/20">
                        <div class="w-12 h-12 bg-emerald-500/20 text-emerald-300 rounded-2xl flex items-center justify-center mx-auto text-xl">
                            📭
                        </div>
                        <h4 class="font-bold text-white text-sm">Belum ada jadwal untuk hari {{ $selectedHari }} di minggu ini.</h4>
                        <p class="text-xs text-slate-400">Silakan tambahkan jadwal baru jika diperlukan.</p>
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection