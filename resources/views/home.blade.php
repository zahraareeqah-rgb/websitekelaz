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
                $gurus = \App\Models\Guru::all(); // Mengambil data guru
                $prestasis = \App\Models\Prestasi::all(); // Mengambil data prestasi/penghargaan
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

    <!-- ================= SECTION BAWAH: CARD KELAS, PENGHARGAAN, & WIDGET ================= -->
    <div class="relative z-10 w-full max-w-7xl mx-auto space-y-8 pt-8 border-t border-white/10 pb-12">

        <div class="flex justify-between items-center">
            <h2 class="text-xl font-black tracking-tight text-white">Popular Class Elements & Members</h2>
            <span class="text-xs text-emerald-400 font-semibold uppercase tracking-wider">XI RPL 1 Dashboard</span>
        </div>

        <!-- 2 Card Besar Statistik & Prestasi/Penghargaan -->
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

            <!-- Card Prestasi / Penghargaan dengan Tombol Tambah & Edit -->
            <div class="bg-gradient-to-br from-slate-900/90 via-amber-950/40 to-slate-900/90 backdrop-blur-2xl p-8 rounded-[2.5rem] border border-amber-500/30 shadow-2xl flex flex-col justify-between space-y-6 relative overflow-hidden group hover:border-amber-400/60 transition duration-500">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex justify-between items-start relative z-10">
                    <span class="text-[11px] bg-amber-500/20 text-amber-300 font-extrabold px-3.5 py-1 rounded-full border border-amber-400/40 uppercase tracking-widest">
                        🏆 Penghargaan & Akademik
                    </span>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('prestasi.create') }}" class="px-4 py-1.5 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-[10px] font-extrabold tracking-wider uppercase shadow-lg transition">
                            + Tambah Penghargaan
                        </a>
                    @endif
                </div>

                <div class="space-y-4 relative z-10">
                    <h3 class="text-2xl font-black text-white tracking-tight">Daftar Penghargaan Kelas</h3>

                    <!-- List Penghargaan -->
                    <div class="space-y-2 max-h-32 overflow-y-auto pr-1">
                        @if(isset($prestasis) && count($prestasis) > 0)
                            @foreach($prestasis as $prestasi)
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-2xl border border-white/10">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg">🥇</span>
                                        <span class="font-bold text-xs text-white">{{ $prestasi->nama_prestasi ?? $prestasi->judul ?? 'Penghargaan Kelas' }}</span>
                                    </div>
                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                        <a href="{{ route('prestasi.edit', $prestasi->id) }}" class="text-[10px] bg-amber-500/20 text-amber-300 px-2.5 py-1 rounded-lg border border-amber-400/30 hover:bg-amber-500/30 font-bold">Edit</a>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="text-xs text-slate-400 italic py-2">Belum ada penghargaan tercatat.</div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-1">
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                            <span class="text-2xl font-black text-blue-400">{{ $totalTugas }}</span>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold mt-1">Tugas Aktif</p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                            <span class="text-2xl font-black text-amber-400">Top 1</span>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold mt-1">Prestasi Sekolah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Fakta Menarik & Quote Inspiratif -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-2">
            <div class="bg-slate-900/60 backdrop-blur-2xl rounded-3xl p-6 md:p-8 border border-white/20 shadow-2xl space-y-4 flex flex-col justify-between"
                 x-data="{
                     fakta: 'Memuat wawasan hari ini...',
                     kategori: 'Wawasan Harian',
                     loading: false,
                     fetchFakta() {
                         this.loading = true;
                         fetch('https://uselessfacts.jsph.pl/api/v2/facts/random?language=en')
                             .then(response => response.json())
                             .then(result => {
                                 if (result && result.text) {
                                     this.fakta = result.text;
                                     this.kategori = 'Wawasan & Pengetahuan Umum';
                                 }
                             })
                             .catch(error => {
                                 this.fakta = 'Tahukah kamu? Otak manusia menghasilkan sekitar 20 watt daya listrik saat terjaga—cukup untuk menyalakan bola lampu kecil! 💡';
                                 this.kategori = 'Fakta Sains';
                             })
                             .finally(() => this.loading = false);
                     }
                 }"
                 x-init="fetchFakta()">
                <div class="flex justify-between items-center">
                    <span class="text-[10px] bg-amber-500/20 text-amber-300 font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-amber-400/30 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"></span>
                        <span x-text="kategori"></span>
                    </span>
                    <button @click="fetchFakta()" :disabled="loading" class="text-[11px] text-amber-300 hover:bg-white/15 transition bg-white/10 px-3 py-1 rounded-xl font-semibold flex items-center gap-1">
                        <span x-text="loading ? '⏳' : '🔄 Fakta Lainnya'"></span>
                    </button>
                </div>
                <div class="flex items-start gap-4 pt-2 flex-1">
                    <span class="text-3xl drop-shadow-lg shrink-0">🧠</span>
                    <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed italic" x-text="'- ' + fakta"></p>
                </div>
                <div class="text-right pt-2 border-t border-white/10">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">1 Hari 1 Wawasan Baru ✨</span>
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

        <!-- ================= DIREKTORI SISWA KELAS (DENGAN TOMBOL EDIT & HAPUS) ================= -->
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-8 border border-emerald-500/30 shadow-2xl space-y-6 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Header Tabel -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/10 pb-5 relative z-10">
                <div>
                    <span class="text-[10px] bg-emerald-500/20 text-emerald-300 font-extrabold px-3 py-1 rounded-full border border-emerald-400/30 uppercase tracking-widest inline-block mb-2">
                        👥 Direktori Anggota
                    </span>
                    <h3 class="font-black text-white text-xl sm:text-2xl tracking-tight">Tabel Daftar Siswa Kelas XI RPL 1</h3>
                    <p class="text-xs text-slate-300 mt-1">Data lengkap keanggotaan kelas, nomor absen terurut abjad, kontak, dan alamat.</p>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('siswa.create') }}" class="px-5 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-2xl text-xs font-extrabold tracking-wider uppercase shadow-xl transition flex items-center gap-2">
                        <span>+</span> Tambah Siswa Baru
                    </a>
                @endif
            </div>

            <!-- Tabel Siswa Lengkap dengan Tombol Aksi (Edit & Hapus) -->
            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-left text-xs text-slate-200 border-collapse">
                    <thead class="bg-white/10 text-emerald-300 uppercase tracking-wider border-b border-white/15">
                        <tr>
                            <th class="p-4 rounded-l-2xl font-extrabold">📌 No Absen</th>
                            <th class="p-4 font-extrabold">📸 Foto & Nama Siswa</th>
                            <th class="p-4 font-extrabold">🆔 NISN</th>
                            <th class="p-4 font-extrabold">🚻 Jenis Kelamin</th>
                            <th class="p-4 font-extrabold">📧 Email Akun</th>
                            <th class="p-4 font-extrabold">📍 Alamat</th>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <th class="p-4 rounded-r-2xl font-extrabold text-right">⚙️ Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @if(isset($siswas) && count($siswas) > 0)
                            @foreach($siswas as $siswa)
                                <tr class="hover:bg-emerald-500/5 transition group">
                                    <td class="p-4 font-black text-emerald-400 text-sm">
                                        <div class="w-9 h-9 bg-emerald-500/20 text-emerald-300 rounded-xl flex items-center justify-center border border-emerald-400/30 shadow-inner">
                                            {{ $siswa->absen ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            @if(isset($siswa->foto) && $siswa->foto)
                                                <img src="{{ asset($siswa->foto) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500/40 shadow-md shrink-0">
                                            @else
                                                <div class="w-10 h-10 bg-slate-800 text-emerald-300 rounded-full flex items-center justify-center font-bold text-base border-2 border-emerald-500/40 shadow-md shrink-0">
                                                    {{ substr($siswa->nama_siswa ?? $siswa->nama ?? 'S', 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <span class="font-extrabold text-white text-sm group-hover:text-emerald-300 transition">{{ $siswa->nama_siswa ?? $siswa->nama }}</span>
                                                <div class="text-[10px] text-emerald-400/80 font-semibold">✨ Anggota Aktif</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 font-semibold text-slate-300 font-mono">{{ $siswa->nisn ?? '-' }}</td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase border {{ ($siswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'bg-blue-500/20 text-blue-300 border-blue-400/30' : 'bg-pink-500/20 text-pink-300 border-pink-400/30' }}">
                                            {{ ($siswa->jenis_kelamin ?? '') == 'Laki-laki' ? '👦 Laki-laki' : '👧 Perempuan' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-slate-300 font-medium">{{ $siswa->email ?? '-' }}</td>
                                    <td class="p-4 text-slate-300 font-medium max-w-xs truncate" title="{{ $siswa->alamat ?? '-' }}">{{ $siswa->alamat ?? '-' }}</td>

                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                        <td class="p-4 text-right space-x-1">
                                            <a href="{{ route('siswa.edit', $siswa->id) }}" class="px-3 py-1 bg-amber-500/20 text-amber-300 border border-amber-400/30 hover:bg-amber-500/30 rounded-lg font-bold text-xs transition inline-block">Edit</a>
                                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500/20 text-red-300 border border-red-400/30 hover:bg-red-500/30 rounded-lg font-bold text-xs transition">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-400 italic text-xs">
                                    📂 Belum ada data siswa terdaftar di kelas.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ================= DAFTAR GURU PENGAJAR (DENGAN TOMBOL TAMBAH, EDIT, & HAPUS) ================= -->
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-8 border border-sky-500/30 shadow-2xl space-y-6 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Header Card Guru (Dilengkapi Tombol Tambah Guru) -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/10 pb-5 relative z-10">
                <div>
                    <span class="text-[10px] bg-sky-500/20 text-sky-300 font-extrabold px-3 py-1 rounded-full border border-sky-400/30 uppercase tracking-widest inline-block mb-2">
                        👨‍🏫 Tenaga Pendidik
                    </span>
                    <h3 class="font-black text-white text-xl sm:text-2xl tracking-tight">Daftar Guru Pengajar Kelas XI RPL 1</h3>
                    <p class="text-xs text-slate-300 mt-1">Informasi guru mata pelajaran yang membimbing di kelas.</p>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('guru.create') }}" class="px-5 py-3 bg-sky-500 hover:bg-sky-400 text-slate-950 rounded-2xl text-xs font-extrabold tracking-wider uppercase shadow-xl transition flex items-center gap-2">
                        <span>+</span> Tambah Guru Baru
                    </a>
                @endif
            </div>

            <!-- Grid Card Guru & Tombol Aksi Edit/Hapus -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 relative z-10">
                @if(isset($gurus) && count($gurus) > 0)
                    @foreach($gurus as $guru)
                        <div class="bg-white/5 border border-white/10 rounded-3xl p-5 hover:border-sky-400/50 transition duration-300 flex flex-col justify-between gap-4 group">

                            <!-- Bagian Atas: Avatar & Info -->
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-sky-500/20 text-sky-300 font-black rounded-2xl flex items-center justify-center text-xl border border-sky-400/30 shadow-inner shrink-0">
                                    👨‍🏫
                                </div>
                                <div class="space-y-1 overflow-hidden">
                                    <h4 class="font-black text-white text-sm truncate group-hover:text-sky-300 transition">{{ $guru->nama_guru ?? $guru->nama }}</h4>
                                    <p class="text-xs text-slate-300 font-medium">📚 {{ $guru->mapel->nama_mapel ?? $guru->mapel ?? 'Pengajar Umum' }}</p>
                                    <span class="inline-block text-[10px] text-sky-400 bg-sky-500/10 px-2.5 py-0.5 rounded-full border border-sky-400/20 font-semibold">Aktif Mengajar</span>
                                </div>
                            </div>

                            <!-- Bagian Bawah: Tombol Edit & Hapus (Khusus Admin) -->
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="pt-3 border-t border-white/10 flex justify-end gap-2">
                                    <a href="{{ route('guru.edit', $guru->id) }}" class="px-3 py-1 bg-amber-500/20 text-amber-300 border border-amber-400/30 hover:bg-amber-500/30 rounded-lg font-bold text-xs transition">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500/20 text-red-300 border border-red-400/30 hover:bg-red-500/30 rounded-lg font-bold text-xs transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-12 text-slate-400 italic text-xs space-y-2">
                        <div class="text-3xl">📂</div>
                        <p>Belum ada data guru pengajar yang dimasukkan.</p>
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
