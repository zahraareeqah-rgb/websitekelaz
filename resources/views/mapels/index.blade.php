@extends('layouts.app')

@section('content')
<!-- Container Utama Fullscreen dengan Background Papan Tulis Kelas -->
<div class="relative min-h-screen -m-6 p-6 md:p-12 bg-cover bg-center bg-fixed text-white font-sans flex flex-col justify-between overflow-x-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');">

    <!-- Overlay Gelap Tipis & Natural -->
    <div class="absolute inset-0 bg-slate-950/45 backdrop-blur-[1px] z-0"></div>

    <!-- WRAPPER UTAMA -->
    <div class="relative z-10 w-full max-w-7xl mx-auto space-y-10 pt-4 pb-16">

        <!-- ================= HERO SECTION (Header Banner) ================= -->
        <div class="bg-gradient-to-br from-slate-900/80 via-emerald-950/50 to-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-10 text-white shadow-2xl border border-white/20 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-2">
                <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] font-extrabold px-3.5 py-1 rounded-full uppercase tracking-widest backdrop-blur-md">
                    📚 Portal Akademik
                </span>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-white flex items-center gap-3">
                    Daftar Mata Pelajaran
                    <span class="animate-bounce">✨</span>
                </h1>
                <p class="text-slate-300 text-xs md:text-sm max-w-xl font-medium">
                    Kelola seluruh mata pelajaran kelas XI RPL 1 lengkap dengan kategori dan informasi pengajarnya secara visual.
                </p>
            </div>

            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="relative z-10">
                    <a href="{{ route('mapel.create') }}" class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl text-xs shadow-xl transition flex items-center gap-2 tracking-wider uppercase">
                        <span>+</span> Tambah Mapel Baru
                    </a>
                </div>
            @endif
        </div>

        <!-- ================= DAFTAR MAPEL DALAM BENTUK CARD DINAMIS ================= -->
        <div class="space-y-6">
            <div class="flex justify-between items-center px-2">
                <h2 class="text-lg font-bold text-white tracking-tight">Koleksi Mata Pelajaran Kelas</h2>
                <span class="px-3.5 py-1 bg-white/10 text-emerald-300 font-semibold text-xs rounded-full border border-white/20 backdrop-blur-md">
                    Total: {{ count($mapels) }} Mapel
                </span>
            </div>

            @if(count($mapels) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($mapels as $mapel)
                        @php
                            $namaMapel = strtolower($mapel->nama_mapel ?? $mapel->nama ?? '');

                            // Logika Otomatis Menyesuaikan Tema Berdasarkan Nama Mapel
                            if (str_contains($namaMapel, 'mtk') || str_contains($namaMapel, 'matematika') || str_contains($namaMapel, 'hitung')) {
                                $badgeText = '📐 Hitung-Hitungan';
                                $badgeColor = 'bg-blue-500/20 text-blue-300 border-blue-400/40';
                                $cardBg = 'from-slate-900/90 via-blue-950/40 to-slate-900/90 border-blue-500/30 hover:border-blue-400/60';
                                $icon = '🔢';
                            } elseif (str_contains($namaMapel, 'bahasa') || str_contains($namaMapel, 'indo') || str_contains($namaMapel, 'inggris') || str_contains($namaMapel, 'sastra')) {
                                $badgeText = '📖 Sastra & Bahasa';
                                $badgeColor = 'bg-amber-500/20 text-amber-300 border-amber-400/40';
                                $cardBg = 'from-slate-900/90 via-amber-950/40 to-slate-900/90 border-amber-500/30 hover:border-amber-400/60';
                                $icon = '✍️';
                            } elseif (str_contains($namaMapel, 'pemrograman') || str_contains($namaMapel, 'produktif') || str_contains($namaMapel, 'rpl') || str_contains($namaMapel, 'komputer')) {
                                $badgeText = '💻 Teknologi & Koding';
                                $badgeColor = 'bg-emerald-500/20 text-emerald-300 border-emerald-400/40';
                                $cardBg = 'from-slate-900/90 via-emerald-950/40 to-slate-900/90 border-emerald-500/30 hover:border-emerald-400/60';
                                $icon = '⚡';
                            } else {
                                $badgeText = '🎓 Umum / Agama';
                                $badgeColor = 'bg-purple-500/20 text-purple-300 border-purple-400/40';
                                $cardBg = 'from-slate-900/90 via-purple-950/40 to-slate-900/90 border-purple-500/30 hover:border-purple-400/60';
                                $icon = '📖';
                            }
                        @endphp

                        <!-- Card Dinamis -->
                        <div class="bg-gradient-to-br {{ $cardBg }} backdrop-blur-2xl p-6 rounded-[2.5rem] border shadow-2xl flex flex-col justify-between space-y-5 relative overflow-hidden group transition duration-500 hover:-translate-y-1">

                            <!-- Header Card -->
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] {{ $badgeColor }} font-extrabold px-3.5 py-1 rounded-full uppercase tracking-widest border backdrop-blur-md">
                                    {{ $badgeText }}
                                </span>
                                <span class="text-3xl p-2 bg-white/5 rounded-2xl border border-white/10 shadow-inner group-hover:scale-110 transition duration-300">
                                    {{ $icon }}
                                </span>
                            </div>

                            <!-- Konten Nama & Keterangan -->
                            <div class="space-y-2">
                                <h3 class="text-xl font-black text-white tracking-tight group-hover:text-emerald-300 transition">
                                    {{ $mapel->nama_mapel ?? $mapel->nama ?? 'Mata Pelajaran' }}
                                </h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-medium">
                                    {{ $mapel->keterangan ?? 'Belum ada keterangan atau deskripsi untuk mata pelajaran ini.' }}
                                </p>
                            </div>

                            <!-- Footer Card / Tombol Aksi Admin -->
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                                    <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Aksi Admin</span>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('mapel.edit', $mapel->id) }}" class="px-3.5 py-1.5 bg-amber-500/20 text-amber-300 border border-amber-400/30 hover:bg-amber-500/30 rounded-xl font-bold text-xs transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3.5 py-1.5 bg-red-500/20 text-red-300 border border-red-400/30 hover:bg-red-500/30 rounded-xl font-bold text-xs transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Tampilan Kosong yang Elegan -->
                <div class="text-center py-16 space-y-4 bg-slate-900/60 backdrop-blur-2xl rounded-[2.5rem] border border-white/20 shadow-2xl max-w-xl mx-auto p-8">
                    <div class="w-16 h-16 bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 rounded-3xl flex items-center justify-center mx-auto text-3xl shadow-inner">
                        📖
                    </div>
                    <h4 class="font-bold text-white text-base">Belum ada mata pelajaran terdaftar.</h4>
                    <p class="text-xs text-slate-300 max-w-sm mx-auto">Silakan tambahkan data mata pelajaran baru melalui tombol di atas jika Anda login sebagai admin.</p>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <div class="pt-2">
                            <a href="{{ route('mapel.create') }}" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-2xl text-xs font-extrabold shadow-lg transition inline-block uppercase tracking-wider">
                                + Tambah Mapel Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
