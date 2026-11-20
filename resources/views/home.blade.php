@extends('layouts.app')

@section('content')
<!-- Container Utama Fullscreen Hero dengan Background Papan Tulis Kelas -->
<div class="relative min-h-screen -m-6 p-6 md:p-10 bg-cover bg-center bg-fixed text-white font-sans flex flex-col justify-between overflow-x-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');" x-data="{ rightSidebarOpen: true }">

    <!-- Overlay Gelap Tipis & Natural -->
    <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-[1px] z-0"></div>

    <!-- ================= HERO SECTION UTAMA (Flex Kiri & Kanan dengan Alpine Toggle) ================= -->
    <div class="relative z-10 w-full max-w-7xl mx-auto flex flex-col xl:flex-row gap-8 items-start pt-6 pb-12">

        <!-- SISI KIRI: Teks Judul Besar Megah -->
        <div class="flex-1 space-y-6 text-left transition-all duration-300">
            <div class="inline-flex items-center space-x-2 text-emerald-300 font-semibold text-xs tracking-widest uppercase bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20 shadow-lg">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Official Portal • XI RPL 1</span>
            </div>

            <!-- Judul Utama Megah Melayang -->
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white leading-none drop-shadow-2xl">
                Adventures <br>
                <span class="text-emerald-400">That Stay</span> <br>
                With You.
            </h1>

            <p class="text-slate-200 text-sm sm:text-base leading-relaxed max-w-xl drop-shadow font-medium">
                Selamat datang kembali, <span class="text-white font-bold">{{ auth()->user()->name }}</span>! Pusat manajemen keanggotaan kelas, jadwal harian, absensi real-time, dan wawasan interaktif kelas XI RPL 1.
            </p>

            <!-- Tombol Aksi Cepat & Toggle Sidebar -->
            <div class="flex flex-wrap items-center gap-4 pt-2">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('siswa.create') }}" class="px-7 py-4 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl shadow-xl transition text-xs tracking-wider uppercase">
                        + Tambah Siswa
                    </a>
                @endif
                <button @click="rightSidebarOpen = !rightSidebarOpen" class="px-7 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-2xl border border-white/20 transition text-xs tracking-wider uppercase shadow-lg flex items-center gap-2">
                    <span x-text="rightSidebarOpen ? 'Sembunyikan Sidebar ›' : '‹ Tampilkan Sidebar'"></span>
                </button>
            </div>
        </div>

        <!-- SISI KANAN: FOTO KELAS BESAR TANPA BINGKAI KOTAK (SAAT SIDEBAR DITUTUP) -->
        <div x-show="!rightSidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="w-full xl:w-[420px] shrink-0">
            <div class="relative group overflow-hidden rounded-3xl shadow-2xl border border-white/20 aspect-[4/3]">
                <img src="{{ asset('images/bg-kelas.jpg') }}" alt="Foto Kelas XI RPL 1" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent flex flex-col justify-end p-6">
                    <span class="text-[10px] bg-emerald-500/30 text-emerald-300 font-bold px-3 py-1 rounded-full border border-emerald-400/40 uppercase w-max mb-2 backdrop-blur-md">
                        ✨ Kenangan Kita
                    </span>
                    <h4 class="text-white font-black text-lg drop-shadow-md">XI RPL 1</h4>
                    <p class="text-xs text-slate-200 mt-1 drop-shadow font-medium">
                        Kebersamaan adalah awal dari kesuksesan bersama.
                    </p>
                </div>
            </div>
        </div>

        <!-- SISI KANAN: SIDEBAR MELAYANG BUKA-TUTUP (TOGGLE) -->
        <div x-show="rightSidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0 scale-95"
             x-transition:enter-end="translate-x-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0 opacity-100 scale-100"
             x-transition:leave-end="translate-x-full opacity-0 scale-95"
             class="w-full xl:w-96 shrink-0 space-y-6">

            @php
                $user = auth()->user();
                $isAdmin = $user && $user->role === 'admin';
                $siswaLogin = !$isAdmin && $user ? \App\Models\Siswa::where('email', $user->email)->first() : null;

                $totalSiswa = isset($siswas) ? count($siswas) : 0;
                $persenHadir = 0;

                if ($isAdmin) {
                    $angkaStatistik = $totalSiswa;
                    $labelStatistik = 'SISWA';
                    $totalAbsenKelas = \App\Models\Absensi::count();
                    $persenHadir = $totalAbsenKelas > 0 ? round((\App\Models\Absensi::where('status', 'Hadir')->count() / $totalAbsenKelas) * 100) : 100;
                } else {
                    $angkaStatistik = ($totalSiswa > 0) ? $totalSiswa - 1 : 0;
                    $labelStatistik = 'TEMAN';
                    if ($siswaLogin) {
                        $absenSiswa = \App\Models\Absensi::where('user_id', $user->id)->get();
                        $totalAbsenSiswa = $absenSiswa->count();
                        $persenHadir = $totalAbsenSiswa > 0 ? round(($absenSiswa->where('status', 'Hadir')->count() / $totalAbsenSiswa) * 100) : 100;
                    }
                }
                $totalTugas = isset($tugasList) ? count($tugasList) : \App\Models\Tugas::count();
            @endphp

            <!-- PANEL PROFIL -->
            <div class="bg-slate-900/70 backdrop-blur-2xl rounded-3xl p-7 text-white shadow-2xl border border-white/20 space-y-6">
                <div class="flex flex-col items-center text-center space-y-3">
                    @if($siswaLogin && $siswaLogin->foto)
                        <img src="{{ asset($siswaLogin->foto) }}" alt="Foto" class="w-20 h-20 rounded-full object-cover shadow-lg border-4 border-emerald-500/30">
                    @else
                        <div class="w-20 h-20 bg-gradient-to-tr from-emerald-600 to-teal-500 text-slate-950 rounded-full flex items-center justify-center font-black text-2xl shadow-lg shadow-emerald-500/20">
                            {{ substr(auth()->user()->name ?? 'Ad', 0, 2) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="font-extrabold text-white text-lg tracking-tight">{{ auth()->user()->name ?? 'Admin Kelas' }}</h3>
                        <span class="inline-block mt-1 px-3 py-0.5 bg-emerald-500/20 text-emerald-300 font-bold text-[10px] tracking-wider rounded-full uppercase border border-emerald-400/30">
                            {{ auth()->user()->role ?? 'ADMIN' }}
                        </span>
                        <p class="text-xs text-slate-300 mt-2 font-medium">Akun aktif terverifikasi.</p>
                    </div>
                </div>

                <hr class="border-white/10">

                <div class="grid grid-cols-3 text-center items-center pt-1">
                    <div>
                        <span class="text-lg font-black text-white">{{ $angkaStatistik }}</span>
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-bold mt-0.5">{{ $labelStatistik }}</p>
                    </div>
                    <div>
                        <span class="text-lg font-black text-white">{{ $totalTugas }}</span>
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-bold mt-0.5">TUGAS</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="relative w-10 h-10 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-white/10" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="text-emerald-400" stroke-dasharray="{{ $persenHadir }}, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <span class="absolute text-[10px] font-extrabold text-white">{{ $persenHadir }}%</span>
                        </div>
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-bold mt-1">KEHADIRAN</p>
                    </div>
                </div>
            </div>

            <!-- Widget Kalender Mini Interaktif & List Tugas per Tanggal -->
            <div class="bg-slate-900/70 backdrop-blur-2xl rounded-3xl p-6 border border-white/20 shadow-2xl space-y-4"
                 x-data="classCalendar(@js($tugasList ?? \App\Models\Tugas::with(['mapel'])->get()))"
                 x-init="initCalendar()">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-white text-sm" x-text="'📅 ' + monthNames[month] + ' ' + year"></h3>
                    <div class="flex gap-1">
                        <button @click="changeMonth(-1)" class="p-1 hover:bg-white/20 rounded-lg text-slate-200 text-xs font-bold">‹</button>
                        <button @click="changeMonth(1)" class="p-1 hover:bg-white/20 rounded-lg text-slate-200 text-xs font-bold">›</button>
                    </div>
                </div>
                <div class="grid grid-cols-7 text-center text-[10px] font-medium text-slate-400">
                    <span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
                </div>
                <div class="grid grid-cols-7 text-center text-xs gap-y-1.5 text-slate-200">
                    <template x-for="date in blankDays"><div></div></template>
                    <template x-for="date in daysInMonth" :key="date">
                        <div @click="selectDate(date)"
                             class="relative py-1.5 rounded-xl cursor-pointer transition flex flex-col items-center justify-center"
                             :class="{
                                 'bg-emerald-500 text-slate-950 font-bold shadow-lg': isSelected(date),
                                 'bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-400/30': isToday(date) && !isSelected(date),
                                 'hover:bg-white/10 text-slate-200': !isSelected(date) && !isToday(date)
                             }">
                            <span x-text="date" class="text-xs"></span>
                            <span x-show="hasTask(date)" class="absolute bottom-0.5 w-1 h-1 rounded-full" :class="isSelected(date) ? 'bg-slate-950' : 'bg-red-400'"></span>
                        </div>
                    </template>
                </div>

                <!-- Bagian Daftar Tugas pada Tanggal yang Dipilih (Routing ke Halaman Tugas) -->
                <div class="pt-3 border-t border-white/10 space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-300 font-bold" x-text="'Tugas tanggal ' + selectedDateFormatted + ':'"></span>
                        <a href="{{ route('tugas.index') }}" class="text-[10px] text-emerald-400 hover:underline font-semibold flex items-center gap-1">
                            <span>Buka Halaman Tugas</span> ›
                        </a>
                    </div>
                    <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                        <template x-for="task in selectedTasks" :key="task.id">
                            <a href="{{ route('tugas.index') }}" class="block p-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl transition space-y-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-extrabold text-emerald-300 uppercase" x-text="task.mapel ? (task.mapel.nama_mapel || task.mapel.nama) : 'Tugas'"></span>
                                    <span class="text-[9px] bg-red-500/20 text-red-300 px-2 py-0.5 rounded-full border border-red-400/30 font-bold" x-text="task.deadline"></span>
                                </div>
                                <p class="text-xs font-bold text-white truncate" x-text="task.judul_tugas"></p>
                            </a>
                        </template>
                        <template x-if="selectedTasks.length === 0">
                            <div class="text-center py-4 text-slate-400 text-[11px] italic">
                                Tidak ada jadwal tugas pada tanggal ini.
                            </div>
                        </template>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- ================= SECTION BAWAH: CARD KELAS, FAKTA MENARIK, & QUOTE ================= -->
    <div class="relative z-10 w-full max-w-7xl mx-auto space-y-8 pt-8 border-t border-white/10 pb-12">

        <div class="flex justify-between items-center">
            <h2 class="text-xl font-black tracking-tight text-white">Popular Class Elements & Members</h2>
            <span class="text-xs text-emerald-400 font-semibold uppercase tracking-wider">XI RPL 1 Dashboard</span>
        </div>

        <!-- 2 Card Besar Statistik & Prestasi -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-slate-900/90 via-emerald-950/40 to-slate-900/90 backdrop-blur-2xl p-8 rounded-[2.5rem] border border-emerald-500/30 shadow-2xl flex flex-col justify-between space-y-6 relative overflow-hidden group hover:border-emerald-400/60 transition duration-500">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex justify-between items-start relative z-10">
                    <span class="text-[11px] bg-emerald-500/20 text-emerald-300 font-extrabold px-3.5 py-1 rounded-full border border-emerald-400/40 uppercase tracking-widest">
                        📊 Statistik & Kehadiran
                    </span>
                    <span class="text-3xl">📈</span>
                </div>
                <div class="space-y-4 relative z-10">
                    <h3 class="text-2xl font-black text-white tracking-tight">Performa & Keanggotaan Kelas</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-medium">
                        Pantau tingkat kehadiran harian seluruh siswa secara real-time dan total keanggotaan aktif terdaftar di kelas XI RPL 1.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                            <span class="text-2xl font-black text-emerald-400">{{ $angkaStatistik }}</span>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold mt-1">Total Keanggotaan</p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                            <span class="text-2xl font-black text-amber-400">{{ $persenHadir }}%</span>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold mt-1">Tingkat Kehadiran</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-slate-900/90 via-amber-950/40 to-slate-900/90 backdrop-blur-2xl p-8 rounded-[2.5rem] border border-amber-500/30 shadow-2xl flex flex-col justify-between space-y-6 relative overflow-hidden group hover:border-amber-400/60 transition duration-500">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex justify-between items-start relative z-10">
                    <span class="text-[11px] bg-amber-500/20 text-amber-300 font-extrabold px-3.5 py-1 rounded-full border border-amber-400/40 uppercase tracking-widest">
                        🏆 Prestasi & Tugas
                    </span>
                    <span class="text-3xl">🏆</span>
                </div>
                <div class="space-y-4 relative z-10">
                    <h3 class="text-2xl font-black text-white tracking-tight">Penghargaan & Akademik Kelas</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-medium">
                        Kumpulan tugas aktif yang harus diselesaikan serta deretan prestasi membanggakan yang diraih oleh kelas XI RPL 1 di tingkat sekolah.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                            <span class="text-2xl font-black text-blue-400">{{ $totalTugas }}</span>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold mt-1">Tugas Aktif</p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                            <span class="text-2xl font-black text-amber-400">Top 1</span>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold mt-1">Penghargaan Sekolah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Fakta Menarik & Quote Inspiratif (Berdampingan di Atas Direktori Siswa) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-2">

            <!-- Widget Fakta Menarik Kelas -->
            <div class="bg-slate-900/60 backdrop-blur-2xl rounded-3xl p-6 md:p-8 border border-white/20 shadow-2xl space-y-4 flex flex-col justify-between"
                 x-data="{
                    faktaIndex: 0,
                    faktaList: [
                        'XI RPL 1 adalah kelas dengan kekompakan ngoding terbaik semester ini! 🚀',
                        'Kopi dan teh adalah bahan bakar utama kelas saat deadline project tiba. ☕',
                        'Sudah lebih dari puluhan baris error berhasil diselesaikan bersama-sama. 🐛',
                        'Kebersamaan adalah kunci utama melewati masa-masa ujian kejuruan. ✨'
                    ],
                    nextFakta() { this.faktaIndex = (this.faktaIndex + 1) % this.faktaList.length; }
                 }">
                <div class="flex justify-between items-center">
                    <span class="text-[10px] bg-amber-500/20 text-amber-300 font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-amber-400/30">✨ Fakta Menarik Kelas</span>
                    <button @click="nextFakta()" class="text-[11px] text-amber-300 hover:bg-white/15 transition bg-white/10 px-3 py-1 rounded-xl font-semibold">
                        <span>🔄 Acak Fakta</span>
                    </button>
                </div>
                <div class="flex items-start gap-4 pt-2 flex-1">
                    <span class="text-3xl drop-shadow-lg">🔥</span>
                    <p class="text-sm text-slate-200 font-medium leading-relaxed" x-text="faktaList[faktaIndex]"></p>
                </div>
            </div>

            <!-- Widget Quote API -->
            <div class="bg-slate-900/60 backdrop-blur-2xl rounded-3xl p-6 md:p-8 border border-white/20 shadow-2xl space-y-4 flex flex-col justify-between"
                 x-data="{
                     quote: 'Memuat quote...',
                     author: 'Mohon tunggu',
                     loading: false,
                     fetchQuote() {
                         this.loading = true;
                         fetch('/api/v1/quote')
                             .then(response => response.json())
                             .then(result => { if (result.success && result.data) { this.quote = result.data.content; this.author = result.data.author; } })
                             .catch(error => console.error(error))
                             .finally(() => this.loading = false);
                     }
                 }"
                 x-init="fetchQuote()">
                <div class="flex justify-between items-center">
                    <span class="text-[10px] bg-sky-500/20 text-sky-300 font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-sky-400/30">💡 Quote Inspiratif (API)</span>
                    <button @click="fetchQuote()" :disabled="loading" class="text-[11px] text-sky-300 hover:bg-white/15 transition bg-white/10 px-3 py-1 rounded-xl font-semibold">
                        <span x-text="loading ? '⏳' : '🔄 Ganti Quote'"></span>
                    </button>
                </div>
                <blockquote class="text-sm italic text-slate-200 font-medium leading-relaxed pt-2">
                    "<span x-text="quote"></span>"
                </blockquote>
                <div class="text-right pt-3 border-t border-white/10">
                    <span class="text-xs font-bold text-sky-300" x-text="'- ' + author"></span>
                </div>
            </div>

        </div>

        <!-- ================= DAFTAR SISWA KELAS LENGKAP (FULL WIDTH DI PALING BAWAH) ================= -->
        <div class="bg-slate-900/60 backdrop-blur-2xl rounded-3xl p-6 md:p-8 border border-white/20 shadow-2xl space-y-6">

            <!-- Header Direktori Siswa -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/10 pb-5">
                <div>
                    <h3 class="font-black text-white text-xl flex items-center gap-2">
                        <span>👥</span> Direktori Siswa Kelas
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">Data lengkap keanggotaan kelas beserta detail informasi kontak dan alamat.</p>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('siswa.create') }}" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-xl text-xs font-extrabold tracking-wider uppercase shadow-lg transition">
                        + Tambah Siswa Baru
                    </a>
                @endif
            </div>

            <!-- List Siswa Memanjang Full Width -->
            <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                @if(isset($siswas) && count($siswas) > 0)
                    @foreach($siswas as $siswa)
                        <!-- Card Identitas Siswa -->
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between p-5 bg-white/5 rounded-2xl border border-white/10 hover:border-emerald-500/40 hover:bg-white/10 transition duration-300 gap-4 relative overflow-hidden group">

                            <!-- Garis Dekorasi Kiri -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500/50 group-hover:bg-emerald-400 transition"></div>

                            <!-- KIRI: Nomor Absen, Foto, Nama, Gender, NISN -->
                            <div class="flex items-center gap-4 pl-3 lg:w-1/3">
                                <!-- Nomor Absen -->
                                <span class="w-10 h-10 bg-emerald-500/20 text-emerald-300 font-black rounded-xl text-sm flex items-center justify-center border border-emerald-400/30 shadow-inner shrink-0">
                                    {{ $siswa->absen ?? '-' }}
                                </span>

                                <!-- Foto Profil -->
                                @if(isset($siswa->foto) && $siswa->foto)
                                    <img src="{{ asset($siswa->foto) }}" alt="Foto" class="w-12 h-12 rounded-full object-cover border-2 border-white/20 shrink-0 shadow-md">
                                @else
                                    <div class="w-12 h-12 bg-slate-800 text-slate-300 rounded-full flex items-center justify-center font-bold text-lg border-2 border-white/20 shrink-0 shadow-md">
                                        {{ substr($siswa->nama_siswa ?? $siswa->nama ?? 'S', 0, 1) }}
                                    </div>
                                @endif

                                <!-- Teks Nama & NISN -->
                                <div class="space-y-0.5">
                                    <h4 class="font-bold text-sm text-white flex items-center gap-2">
                                        {{ $siswa->nama_siswa ?? $siswa->nama }}
                                        <span class="text-[9px] px-2 py-0.5 bg-white/10 text-slate-300 rounded-full border border-white/10 uppercase tracking-widest font-semibold">
                                            {{ $siswa->jenis_kelamin ?? 'L/P' }}
                                        </span>
                                    </h4>
                                    <p class="text-xs text-emerald-400 font-semibold tracking-wide">NISN: {{ $siswa->nisn ?? 'Belum diatur' }}</p>
                                </div>
                            </div>

                            <!-- TENGAH: Email & Alamat -->
                            <div class="flex-1 space-y-2 text-slate-300 bg-white/5 p-3 rounded-xl border border-white/5">
                                <div class="flex items-start gap-2 text-xs">
                                    <span class="shrink-0 mt-0.5">📧</span>
                                    <span class="break-all font-medium">{{ $siswa->email ?? 'Email tidak tersedia' }}</span>
                                </div>
                                <div class="flex items-start gap-2 text-xs">
                                    <span class="shrink-0 mt-0.5">📍</span>
                                    <span class="leading-relaxed font-medium">{{ $siswa->alamat ?? 'Alamat belum diatur' }}</span>
                                </div>
                            </div>

                            <!-- KANAN: Status Label -->
                            <div class="flex items-center justify-end lg:w-1/6 shrink-0 pt-2 lg:pt-0">
                                <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-300 text-xs font-bold rounded-xl border border-emerald-400/20 shadow-sm flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Status Aktif
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Tampilan Jika Kosong -->
                    <div class="text-center py-12 space-y-3 bg-white/5 rounded-2xl border border-white/10">
                        <div class="text-4xl">📂</div>
                        <h4 class="text-white font-bold text-sm">Belum Ada Data Siswa</h4>
                        <p class="text-slate-400 text-xs">Silakan tambahkan data siswa pertama menggunakan tombol di atas.</p>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>

<!-- Script Alpine.js Kalender & Filter Tugas -->
<script>
    function classCalendar(tasksData) {
        return {
            month: new Date().getMonth(),
            year: new Date().getFullYear(),
            daysInMonth: 0,
            blankDays: [],
            monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            selectedDay: new Date().getDate(),
            tasks: tasksData,
            initCalendar() { this.getDays(); },
            getDays() {
                let days = new Date(this.year, this.month + 1, 0).getDate();
                let startDay = new Date(this.year, this.month, 1).getDay();
                let adjustedStartDay = startDay === 0 ? 6 : startDay - 1;
                this.blankDays = Array.from({ length: adjustedStartDay });
                this.daysInMonth = Array.from({ length: days }, (_, i) => i + 1);
            },
            changeMonth(val) {
                if (this.month + val > 11) { this.month = 0; this.year++; }
                else if (this.month + val < 0) { this.month = 11; this.year--; }
                else { this.month += val; }
                this.getDays();
            },
            isToday(date) {
                const today = new Date();
                return date === today.getDate() && this.month === today.getMonth() && this.year === today.getFullYear();
            },
            isSelected(date) { return date === this.selectedDay; },
            selectDate(date) { this.selectedDay = date; },
            formatDateString(date) {
                let d = String(date).padStart(2, '0');
                let m = String(this.month + 1).padStart(2, '0');
                return `${this.year}-${m}-${d}`;
            },
            hasTask(date) {
                let dateStr = this.formatDateString(date);
                return this.tasks.some(task => {
                    if (!task.deadline) return false;
                    let taskDate = task.deadline.split('T')[0].split(' ')[0];
                    return taskDate === dateStr;
                });
            },
            get selectedTasks() {
                let dateStr = this.formatDateString(this.selectedDay);
                return this.tasks.filter(task => {
                    if (!task.deadline) return false;
                    let taskDate = task.deadline.split('T')[0].split(' ')[0];
                    return taskDate === dateStr;
                });
            },
            get selectedDateFormatted() { return `${this.selectedDay} ${this.monthNames[this.month]} ${this.year}`; }
        }
    }
</script>
@endsection
