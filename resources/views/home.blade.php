@extends('layouts.app')

@section('content')
<!-- Container Utama Fullscreen dengan Background Papan Tulis Kelas & Dinamis Light/Dark Mode -->
<div class="relative min-h-screen -m-6 p-6 md:p-10 bg-cover bg-center bg-fixed text-slate-800 dark:text-white font-sans flex flex-col justify-between overflow-x-hidden transition-colors duration-300" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');" x-data="{ rightSidebarOpen: false, activeModal: null }">

    <!-- Overlay Gelap Tipis & Natural -->
    <div class="absolute inset-0 bg-slate-950/40 dark:bg-slate-950/40 backdrop-blur-[1px] z-0"></div>

    <!-- ================= HERO SECTION UTAMA ================= -->
    <div class="relative z-10 w-full max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-12 gap-8 items-start pt-6 pb-12">

        <!-- SISI KIRI: Teks Judul Besar Megah -->
        <div class="xl:col-span-7 space-y-6 text-left transition-all duration-300">
            <div class="inline-flex items-center space-x-2 text-emerald-600 dark:text-emerald-300 font-semibold text-xs tracking-widest uppercase bg-white/80 dark:bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-slate-200 dark:border-white/20 shadow-lg">
                <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                <span>Official Portal • XI RPL 1</span>
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-900 dark:text-white leading-none drop-shadow-2xl">
                Adventures <br>
                <span class="text-emerald-600 dark:text-emerald-400">That Stay</span> <br>
                With You.
            </h1>

            <p class="text-slate-600 dark:text-slate-200 text-sm sm:text-base leading-relaxed max-w-xl drop-shadow font-medium">
                Selamat datang kembali, <span class="text-slate-900 dark:text-white font-bold">{{ auth()->user()->name }}</span>! Pusat manajemen keanggotaan kelas, jadwal harian, absensi real-time, dan wawasan interaktif kelas XI RPL 1.
            </p>

            <div class="flex flex-wrap items-center gap-4 pt-2">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('siswa.create') }}" class="px-7 py-4 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl shadow-xl transition text-xs tracking-wider uppercase">
                        + Tambah Siswa
                    </a>
                @endif
                <button @click="rightSidebarOpen = !rightSidebarOpen" class="px-7 py-4 bg-white/80 dark:bg-white/10 hover:bg-white dark:hover:bg-white/20 backdrop-blur-md text-slate-800 dark:text-white font-bold rounded-2xl border border-slate-200 dark:border-white/20 transition text-xs tracking-wider uppercase shadow-lg flex items-center gap-2">
                    <span x-text="rightSidebarOpen ? 'Sembunyikan Sidebar ›' : '‹ Tampilkan Sidebar'"></span>
                </button>
            </div>
        </div>

        <!-- SISI KANAN: SLIDESHOW FOTO -->
        <div x-show="!rightSidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="xl:col-span-5 w-full max-w-md mx-auto"
             x-data="{
                 activeSlide: 0,
                 slides: [
                     '{{ asset('images/foto-1.jpg') }}', '{{ asset('images/foto-2.jpg') }}', '{{ asset('images/foto-3.jpg') }}',
                     '{{ asset('images/foto-4.jpg') }}', '{{ asset('images/foto-5.jpg') }}', '{{ asset('images/foto-6.jpg') }}',
                     '{{ asset('images/foto-7.jpg') }}', '{{ asset('images/foto-8.jpg') }}', '{{ asset('images/foto-9.jpg') }}',
                     '{{ asset('images/foto-10.jpg') }}', '{{ asset('images/foto-11.jpg') }}', '{{ asset('images/foto-12.jpg') }}',
                     '{{ asset('images/foto-13.jpg') }}', '{{ asset('images/foto-14.jpg') }}', '{{ asset('images/foto-15.jpg') }}',
                     '{{ asset('images/foto-16.jpg') }}', '{{ asset('images/foto-17.jpg') }}', '{{ asset('images/foto-18.jpg') }}',
                     '{{ asset('images/foto-19.jpg') }}', '{{ asset('images/foto-20.jpg') }}'
                 ],
                 initSlideshow() {
                     setInterval(() => {
                         this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                     }, 5000);
                 }
             }"
             x-init="initSlideshow()">
             
            <div class="relative group overflow-hidden rounded-3xl shadow-2xl border border-slate-200 dark:border-white/20 aspect-[4/3]">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === index"
                         x-transition:enter="transition-opacity duration-1000 ease-in-out"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity duration-1000 ease-in-out"
                         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                         class="absolute inset-0">
                        <img :src="slide" alt="Foto Kenangan Kelas XI RPL 1" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                    </div>
                </template>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent flex flex-col justify-end p-6 pointer-events-none">
                    <span class="text-[10px] bg-emerald-500/30 text-emerald-300 font-bold px-3 py-1 rounded-full border border-emerald-400/40 uppercase w-max mb-2 backdrop-blur-md">
                        — Since July 2025
                    </span>
                    <h4 class="text-white font-black text-lg drop-shadow-md">XI RPL 1</h4>
                    <p class="text-xs text-slate-200 mt-1 drop-shadow font-medium">This is us-</p>
                </div>
            </div>
        </div>

        <!-- SISI KANAN: SIDEBAR (PROFIL & KALENDER MINI LENGKAP) -->
        <div x-show="rightSidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0 scale-95"
             x-transition:enter-end="translate-x-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0 opacity-100 scale-100"
             x-transition:leave-end="translate-x-full opacity-0 scale-95"
             class="xl:col-span-5 w-full max-w-md mx-auto space-y-6">

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
                $gurus = \App\Models\Guru::all(); 
                $prestasis = \App\Models\Prestasi::all(); 
            @endphp

            <!-- PANEL PROFIL -->
            <div class="bg-white/90 dark:bg-slate-900/70 backdrop-blur-2xl rounded-3xl p-7 text-slate-800 dark:text-white shadow-2xl border border-slate-200 dark:border-white/20 space-y-6 transition-colors duration-300">
                <div class="flex flex-col items-center text-center space-y-3">
                    @if($siswaLogin && $siswaLogin->foto)
                        <img src="{{ asset($siswaLogin->foto) }}" alt="Foto" class="w-20 h-20 rounded-full object-cover shadow-lg border-4 border-emerald-500/30">
                    @else
                        <div class="w-20 h-20 bg-gradient-to-tr from-emerald-500 to-teal-400 text-slate-950 rounded-full flex items-center justify-center font-black text-2xl shadow-lg shadow-emerald-500/20">
                            {{ substr(auth()->user()->name ?? 'Ad', 0, 2) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-lg tracking-tight">{{ auth()->user()->name ?? 'Admin Kelas' }}</h3>
                        <span class="inline-block mt-1 px-3 py-0.5 bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-300 font-bold text-[10px] tracking-wider rounded-full uppercase border border-emerald-500/30">
                            {{ auth()->user()->role ?? 'ADMIN' }}
                        </span>
                        <p class="text-xs text-slate-500 dark:text-slate-300 mt-2 font-medium">Akun aktif terverifikasi.</p>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-white/10">

                <div class="grid grid-cols-3 text-center items-center pt-1">
                    <div>
                        <span class="text-lg font-black text-slate-900 dark:text-white">{{ $angkaStatistik }}</span>
                        <p class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold mt-0.5">{{ $labelStatistik }}</p>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 dark:text-white">{{ $totalTugas }}</span>
                        <p class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold mt-0.5">TUGAS</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="relative w-10 h-10 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-slate-200 dark:text-white/10" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="text-emerald-500 dark:text-emerald-400" stroke-dasharray="{{ $persenHadir }}, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <span class="absolute text-[10px] font-extrabold text-slate-800 dark:text-white">{{ $persenHadir }}%</span>
                        </div>
                        <p class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold mt-1">KEHADIRAN</p>
                    </div>
                </div>
            </div>

            <!-- Kalender Mini & List Tugas Interaktif -->
            <div class="bg-white/90 dark:bg-slate-900/70 backdrop-blur-2xl rounded-3xl p-6 border border-slate-200 dark:border-white/20 shadow-2xl space-y-4 transition-colors duration-300"
                 x-data="classCalendar(@js($tugasList ?? \App\Models\Tugas::with(['mapel'])->get()))"
                 x-init="initCalendar()">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm" x-text="'📅 ' + monthNames[month] + ' ' + year"></h3>
                    <div class="flex gap-1">
                        <button @click="changeMonth(-1)" class="p-1 hover:bg-slate-100 dark:hover:bg-white/20 rounded-lg text-slate-600 dark:text-slate-200 text-xs font-bold transition">‹</button>
                        <button @click="changeMonth(1)" class="p-1 hover:bg-slate-100 dark:hover:bg-white/20 rounded-lg text-slate-600 dark:text-slate-200 text-xs font-bold transition">›</button>
                    </div>
                </div>
                <div class="grid grid-cols-7 text-center text-[10px] font-medium text-slate-500 dark:text-slate-400">
                    <span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
                </div>
                <div class="grid grid-cols-7 text-center text-xs gap-y-1.5 text-slate-700 dark:text-slate-200">
                    <template x-for="date in blankDays"><div></div></template>
                    <template x-for="date in daysInMonth" :key="date">
                        <div @click="selectDate(date)"
                             class="relative py-1.5 rounded-xl cursor-pointer transition flex flex-col items-center justify-center"
                             :class="{
                                 'bg-emerald-500 text-slate-950 font-bold shadow-lg': isSelected(date),
                                 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 font-bold border border-emerald-400/30': isToday(date) && !isSelected(date),
                                 'hover:bg-slate-100 dark:hover:bg-white/10 text-slate-700 dark:text-slate-200': !isSelected(date) && !isToday(date)
                             }">
                            <!-- Angka Tanggal: Merah untuk Hari Minggu / Libur Nasional, Biru/Cyan untuk Hari Penting -->
                            <span x-text="date" class="text-xs font-bold" :class="{
                                'text-red-500 dark:text-red-400 font-black': isNationalHoliday(date),
                                'text-sky-500 dark:text-sky-400 font-black': isSpecialDay(date)
                            }"></span>
                            
                            <!-- Indikator Titik (Hari Minggu bersih tanpa titik merah libur ganda) -->
                            <div class="absolute bottom-0.5 flex gap-0.5">
                                <span x-show="hasTask(date)" class="w-1.5 h-1.5 rounded-full" :class="isSelected(date) ? 'bg-slate-950' : 'bg-red-500'"></span>
                                <span x-show="isHoliday(date) && !isSunday(date)" class="w-1.5 h-1.5 rounded-full" :class="isNationalHoliday(date) ? 'bg-red-500' : 'bg-sky-400'" :title="getHolidayName(date)"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- List Tugas & Keterangan Hari Spesial -->
                <div class="pt-3 border-t border-slate-200 dark:border-white/10 space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-700 dark:text-slate-300 font-bold" x-text="'Agenda ' + selectedDateFormatted + ':'"></span>
                        <a href="{{ route('tugas.index') }}" class="text-[10px] text-emerald-600 dark:text-emerald-400 hover:underline font-semibold flex items-center gap-1">
                            <span>Semua Tugas</span> ›
                        </a>
                    </div>

                    <!-- Banner Informasi Hari Libur / Spesial -->
                    <template x-if="selectedHolidayName">
                        <div class="p-3 bg-sky-500/10 border border-sky-400/30 rounded-2xl text-xs text-sky-600 dark:text-sky-300 font-semibold flex items-center gap-2">
                            <span>📌</span>
                            <span x-text="selectedHolidayName"></span>
                        </div>
                    </template>
                    
                    <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                        <template x-for="task in selectedTasks" :key="task.id">
                            <a :href="'{{ route('tugas.index') }}?highlight=' + task.id" class="block p-3 bg-slate-50 dark:bg-white/5 hover:bg-slate-100 dark:hover:bg-white/10 border border-slate-200 dark:border-white/10 hover:border-emerald-500/40 rounded-2xl transition space-y-1 group">
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-extrabold text-emerald-600 dark:text-emerald-300 uppercase tracking-wider" x-text="task.mapel ? (task.mapel.nama_mapel || task.mapel.nama) : 'Tugas'"></span>
                                    <span class="text-[9px] bg-red-500/20 text-red-600 dark:text-red-300 px-2 py-0.5 rounded-full border border-red-400/30 font-bold" x-text="task.deadline"></span>
                                </div>
                                <p class="text-xs font-bold text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-300 transition truncate" x-text="task.judul_tugas"></p>
                            </a>
                        </template>
                        
                        <template x-if="selectedTasks.length === 0 && !selectedHolidayName">
                            <div class="text-center py-4 text-slate-500 dark:text-slate-400 text-[11px] italic bg-slate-50 dark:bg-white/5 rounded-2xl border border-slate-200 dark:border-white/10">
                                Tidak ada jadwal tugas / agenda pada tanggal ini.
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- ================= SECTION BAWAH: STATISTIK & PENGHARGAAN ================= -->
    <div class="relative z-10 w-full max-w-7xl mx-auto space-y-8 pt-8 border-t border-slate-200 dark:border-white/10 pb-12">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-black tracking-tight text-slate-900 dark:text-white">Popular Class Elements & Members</h2>
            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold uppercase tracking-wider">XI RPL 1 Dashboard</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Statistik -->
            <div class="bg-white/90 dark:bg-gradient-to-br dark:from-slate-900/90 dark:via-emerald-950/40 dark:to-slate-900/90 backdrop-blur-2xl p-8 rounded-[2.5rem] border border-slate-200 dark:border-emerald-500/30 shadow-2xl flex flex-col justify-between space-y-6 relative overflow-hidden group hover:border-emerald-500/60 transition duration-500">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex justify-between items-start relative z-10">
                    <span class="text-[11px] bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-300 font-extrabold px-3.5 py-1 rounded-full border border-emerald-500/30 uppercase tracking-widest">
                        📊 Statistik & Kehadiran
                    </span>
                    <span class="text-3xl">📈</span>
                </div>
                <div class="space-y-4 relative z-10">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Performa & Keanggotaan Kelas</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                        Pantau tingkat kehadiran harian seluruh siswa secara real-time dan total keanggotaan aktif terdaftar di kelas XI RPL 1.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="bg-slate-50 dark:bg-white/5 p-4 rounded-2xl border border-slate-200 dark:border-white/10">
                            <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $angkaStatistik }}</span>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold mt-1">Total Keanggotaan</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-white/5 p-4 rounded-2xl border border-slate-200 dark:border-white/10">
                            <span class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ $persenHadir }}%</span>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold mt-1">Tingkat Kehadiran</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penghargaan -->
            <div class="bg-white/90 dark:bg-gradient-to-br dark:from-slate-900/90 dark:via-amber-950/40 dark:to-slate-900/90 backdrop-blur-2xl p-8 rounded-[2.5rem] border border-slate-200 dark:border-amber-500/30 shadow-2xl flex flex-col justify-between space-y-6 relative overflow-hidden group hover:border-amber-500/60 transition duration-500">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex justify-between items-start relative z-10">
                    <span class="text-[11px] bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-300 font-extrabold px-3.5 py-1 rounded-full border border-amber-500/30 uppercase tracking-widest">
                        🏆 Penghargaan & Akademik
                    </span>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('prestasi.create') }}" class="px-4 py-1.5 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-[10px] font-extrabold tracking-wider uppercase shadow-lg transition">
                            + Tambah Penghargaan
                        </a>
                    @endif
                </div>
                <div class="space-y-4 relative z-10">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Daftar Penghargaan Kelas</h3>
                    <div class="space-y-2.5 max-h-48 overflow-y-auto pr-1">
                        @if(isset($prestasis) && count($prestasis) > 0)
                            @foreach($prestasis as $prestasi)
                                <div class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-white/5 rounded-2xl border border-slate-200 dark:border-white/10 hover:border-amber-500/40 transition">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <span class="text-lg shrink-0">🥇</span>
                                        <div class="truncate">
                                            <span class="font-bold text-xs text-slate-800 dark:text-white block truncate">{{ $prestasi->nama_prestasi ?? $prestasi->judul ?? 'Penghargaan Kelas' }}</span>
                                            @if(!empty($prestasi->kategori) || !empty($prestasi->deskripsi))
                                                <span class="text-[10px] text-amber-600 dark:text-amber-300 font-medium truncate block">{{ $prestasi->kategori ?? $prestasi->deskripsi }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <a href="{{ route('prestasi.edit', $prestasi->id) }}" class="px-3 py-1 bg-amber-500/20 text-amber-700 dark:text-amber-300 border border-amber-400/30 hover:bg-amber-500/30 rounded-xl font-bold text-[11px] transition">Edit</a>
                                            <form action="{{ route('prestasi.destroy', $prestasi->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus penghargaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500/20 text-red-600 dark:text-red-300 border border-red-400/30 hover:bg-red-500/30 rounded-xl font-bold text-[11px] transition">Hapus</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="text-xs text-slate-500 dark:text-slate-400 italic py-4 text-center bg-slate-50 dark:bg-white/5 rounded-2xl border border-slate-200 dark:border-white/10">
                                Belum ada penghargaan tercatat.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= DIREKTORI SISWA KELAS ================= -->
        <div class="bg-white/90 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-8 border border-slate-200 dark:border-emerald-500/30 shadow-2xl space-y-6 relative overflow-hidden transition-colors duration-300">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 dark:border-white/10 pb-5 relative z-10">
                <div>
                    <span class="text-[10px] bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-300 font-extrabold px-3 py-1 rounded-full border border-emerald-500/30 uppercase tracking-widest inline-block mb-2">
                        👥 Direktori Anggota
                    </span>
                    <h3 class="font-black text-slate-900 dark:text-white text-xl sm:text-2xl tracking-tight">Tabel Daftar Siswa Kelas XI RPL 1</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 mt-1">Klik pada nama siswa untuk melihat kartu profil lengkap secara instan.</p>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('siswa.create') }}" class="px-5 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-2xl text-xs font-extrabold tracking-wider uppercase shadow-xl transition flex items-center gap-2">
                        <span>+</span> Tambah Siswa Baru
                    </a>
                @endif
            </div>

            <!-- Tabel Siswa -->
            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-left text-xs text-slate-700 dark:text-slate-200 border-collapse">
                    <thead class="bg-slate-100 dark:bg-white/10 text-emerald-700 dark:text-emerald-300 uppercase tracking-wider border-b border-slate-200 dark:border-white/15">
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
                    <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                        @if(isset($siswas) && count($siswas) > 0)
                            @foreach($siswas as $siswa)
                                <tr class="hover:bg-emerald-500/5 transition group">
                                    <td class="p-4 font-black text-emerald-600 dark:text-emerald-400 text-sm">
                                        <div class="w-9 h-9 bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 rounded-xl flex items-center justify-center border border-emerald-500/30 shadow-inner">
                                            {{ $siswa->absen ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <button @click="activeModal = {{ $siswa->id }}" class="flex items-center gap-3 text-left group/btn focus:outline-none">
                                            @if(isset($siswa->foto) && $siswa->foto)
                                                <img src="{{ asset($siswa->foto) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500/40 shadow-md shrink-0 group-hover/btn:scale-105 transition">
                                            @else
                                                <div class="w-10 h-10 bg-slate-200 dark:bg-slate-800 text-emerald-700 dark:text-emerald-300 rounded-full flex items-center justify-center font-bold text-base border-2 border-emerald-500/40 shadow-md shrink-0">
                                                    {{ substr($siswa->nama_siswa ?? $siswa->nama ?? 'S', 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <span class="font-extrabold text-slate-900 dark:text-white text-sm group-hover/btn:text-emerald-600 dark:group-hover/btn:text-emerald-300 group-hover/btn:underline transition block">{{ $siswa->nama_siswa ?? $siswa->nama }}</span>
                                                <div class="text-[10px] text-emerald-600/80 dark:text-emerald-400/80 font-semibold">✨ Klik untuk Detail Profil</div>
                                            </div>
                                        </button>
                                    </td>
                                    <td class="p-4 font-semibold text-slate-600 dark:text-slate-300 font-mono">{{ $siswa->nisn ?? '-' }}</td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase border {{ ($siswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'bg-blue-500/10 text-blue-700 dark:text-blue-300 border-blue-400/30' : 'bg-pink-500/10 text-pink-700 dark:text-pink-300 border-pink-400/30' }}">
                                            {{ ($siswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-slate-600 dark:text-slate-300 font-medium">{{ $siswa->email ?? '-' }}</td>
                                    <td class="p-4 text-slate-600 dark:text-slate-300 font-medium max-w-xs truncate" title="{{ $siswa->alamat ?? '-' }}">{{ $siswa->alamat ?? '-' }}</td>

                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                        <td class="p-4 text-right space-x-1">
                                            <a href="{{ route('siswa.edit', $siswa->id) }}" class="px-3 py-1 bg-amber-500/20 text-amber-700 dark:text-amber-300 border border-amber-400/30 hover:bg-amber-500/30 rounded-lg font-bold text-xs transition inline-block">Edit</a>
                                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500/20 text-red-600 dark:text-red-300 border border-red-400/30 hover:bg-red-500/30 rounded-lg font-bold text-xs transition">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-500 dark:text-slate-400 italic text-xs">
                                    📂 Belum ada data siswa terdaftar di kelas.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ================= MODAL POPUP GLOBAL (PROFIL SISWA) ================= -->
    @if(isset($siswas) && count($siswas) > 0)
        @foreach($siswas as $siswa)
            <div x-show="activeModal === {{ $siswa->id }}"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md overflow-y-auto"
                 style="display: none;">
                
                <div @click.away="activeModal = null" class="bg-white dark:bg-slate-900 border border-emerald-500/40 w-full max-w-md rounded-[2.5rem] p-6 md:p-8 shadow-2xl relative space-y-6 text-slate-800 dark:text-white overflow-y-auto max-h-[90vh] my-auto">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="flex justify-between items-start">
                        <span class="text-[10px] bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 font-extrabold px-3 py-1 rounded-full border border-emerald-500/30 uppercase tracking-widest">
                            📌 No. Absen {{ $siswa->absen ?? '-' }}
                        </span>
                        <button @click="activeModal = null" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/10 hover:bg-slate-200 dark:hover:bg-white/20 flex items-center justify-center text-slate-700 dark:text-slate-300 font-bold transition">
                            ✕
                        </button>
                    </div>

                    <div class="flex flex-col items-center text-center space-y-3">
                        @if(isset($siswa->foto) && $siswa->foto)
                            <img src="{{ asset($siswa->foto) }}" alt="Foto" class="w-24 h-24 rounded-full object-cover border-4 border-emerald-500/40 shadow-xl">
                        @else
                            <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 text-emerald-700 dark:text-emerald-300 rounded-full flex items-center justify-center font-black text-3xl border-4 border-emerald-500/40 shadow-xl">
                                {{ substr($siswa->nama_siswa ?? $siswa->nama ?? 'S', 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="text-xl font-black text-slate-900 dark:text-white">{{ $siswa->nama_siswa ?? $siswa->nama }}</h4>
                            <p class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-0.5">Siswa Aktif Kelas XI RPL 1</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs pt-2">
                        <div class="bg-slate-50 dark:bg-white/5 p-3.5 rounded-2xl border border-slate-200 dark:border-white/10 space-y-1">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Nomor NISN</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white text-sm">{{ $siswa->nisn ?? '-' }}</span>
                        </div>
                        <div class="bg-slate-50 dark:bg-white/5 p-3.5 rounded-2xl border border-slate-200 dark:border-white/10 space-y-1">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Jenis Kelamin</span>
                            <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $siswa->jenis_kelamin ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="bg-slate-50 dark:bg-white/5 p-3.5 rounded-2xl border border-slate-200 dark:border-white/10 space-y-1 text-xs">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Email Akun</span>
                        <span class="font-medium text-slate-700 dark:text-slate-200">{{ $siswa->email ?? '-' }}</span>
                    </div>

                    <div class="bg-slate-50 dark:bg-white/5 p-3.5 rounded-2xl border border-slate-200 dark:border-white/10 space-y-1 text-xs">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Alamat Lengkap</span>
                        <span class="font-medium text-slate-700 dark:text-slate-200 leading-relaxed">{{ $siswa->alamat ?? '-' }}</span>
                    </div>

                    <div class="pt-2">
                        <button @click="activeModal = null" class="w-full py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl text-xs uppercase tracking-wider shadow-lg transition">
                            Tutup Kartu Profil
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

</div>

<!-- TABEL DAFTAR GURU PENGAJAR -->
<div class="mt-10 space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-xl">👩‍🏫</span>
            <h2 class="text-lg font-bold text-white tracking-tight">Daftar Guru Pengajar</h2>
        </div>
        <!-- Tombol Tambah Guru -->
        <a href="{{ route('guru.create') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs shadow transition flex items-center gap-1.5">
            <span>+</span> Tambah Guru
        </a>
    </div>

    <!-- Container Daftar Guru -->
    <div class="space-y-3">
        @forelse($gurus as $index => $guru)
            <div class="bg-slate-900/85 backdrop-blur-xl border border-white/10 rounded-2xl p-4 flex items-center justify-between text-white shadow-lg transition hover:border-amber-400/50">
                <div class="flex items-center gap-4">
                    <!-- Nomor urut -->
                    <span class="w-8 h-8 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-xs font-bold text-amber-400">
                        {{ $index + 1 }}
                    </span>
                    <div>
                        <h3 class="text-xs font-bold text-white">{{ $guru->nama_guru }}</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">
                            Mapel: <span class="text-amber-300 font-medium">{{ $guru->mapel->nama_mapel ?? $guru->mata_pelajaran ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Tombol Aksi Edit & Hapus -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('guru.edit', $guru->id) }}" class="px-3 py-1.5 bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/30 rounded-xl text-[11px] font-semibold transition">
                        Edit
                    </a>
                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 border border-rose-500/30 rounded-xl text-[11px] font-semibold transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-6 text-center text-slate-400 text-xs">
                Belum ada data guru pengajar yang ditambahkan.
            </div>
        @endforelse
    </div>
</div>

<!-- Script Alpine.js Kalender Interaktif -->
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
            holidays: [],

            initCalendar() {
                this.getDays();
                this.fetchHolidays();
            },

            getDays() {
                let days = new Date(this.year, this.month + 1, 0).getDate();
                let startDay = new Date(this.year, this.month, 1).getDay();
                let adjustedStartDay = startDay === 0 ? 6 : startDay - 1;
                this.blankDays = Array.from({ length: adjustedStartDay });
                this.daysInMonth = Array.from({ length: days }, (_, i) => i + 1);
            },

            fetchHolidays() {
                fetch(`/api/holidays?year=${this.year}`)
                    .then(res => res.json())
                    .then(data => { 
                        this.holidays = data; 
                    })
                    .catch(err => console.error("Gagal memuat hari libur:", err));
            },

            changeMonth(val) {
                if (this.month + val > 11) { this.month = 0; this.year++; }
                else if (this.month + val < 0) { this.month = 11; this.year--; }
                else { this.month += val; }
                this.getDays();
                this.fetchHolidays();
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

            isHoliday(date) {
                let dateStr = this.formatDateString(date);
                return this.holidays.some(h => h.holiday_date === dateStr);
            },

            // Deteksi Hari Minggu Otomatis
            isSunday(date) {
                let dayOfWeek = new Date(this.year, this.month, date).getDay();
                return dayOfWeek === 0; // 0 adalah hari Minggu
            },

            // Tanggal Merah (Libur Nasional ATAU Hari Minggu)
            isNationalHoliday(date) {
                if (this.isSunday(date)) return true;
                let dateStr = this.formatDateString(date);
                let found = this.holidays.find(h => h.holiday_date === dateStr);
                return found ? found.is_national_holiday : false;
            },

            // Hari Penting/Edukasi Biasa (Bukan Hari Minggu & Bukan Tanggal Merah)
            isSpecialDay(date) {
                if (this.isSunday(date)) return false;
                let dateStr = this.formatDateString(date);
                let found = this.holidays.find(h => h.holiday_date === dateStr);
                return found ? !found.is_national_holiday : false;
            },

            getHolidayName(date) {
                if (this.isSunday(date)) return "Hari Minggu (Libur Akhir Pekan)";
                let dateStr = this.formatDateString(date);
                let found = this.holidays.find(h => h.holiday_date === dateStr);
                return found ? found.holiday_name : '';
            },

            hasTask(date) {
                let dateStr = this.formatDateString(date);
                return this.tasks.some(task => {
                    if (!task.deadline) return false;
                    let taskDate = task.deadline.toString().split('T')[0].split(' ')[0];
                    return taskDate === dateStr;
                });
            },

            get selectedTasks() {
                let dateStr = this.formatDateString(this.selectedDay);
                return this.tasks.filter(task => {
                    if (!task.deadline) return false;
                    let taskDate = task.deadline.toString().split('T')[0].split(' ')[0];
                    return taskDate === dateStr;
                });
            },

            get selectedHolidayName() {
                if (this.isSunday(this.selectedDay)) return "Hari Minggu (Libur Akhir Pekan)";
                let dateStr = this.formatDateString(this.selectedDay);
                let found = this.holidays.find(h => h.holiday_date === dateStr);
                return found ? found.holiday_name : null;
            },

            get selectedDateFormatted() { return `${this.selectedDay} ${this.monthNames[this.month]} ${this.year}`; }
        }
    }
</script>
@endsection