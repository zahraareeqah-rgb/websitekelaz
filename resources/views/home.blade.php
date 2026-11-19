@extends('layouts.app')

@section('content')
<!-- Kita bungkus dengan Alpine.js data untuk mengatur buka-tutup sidebar kanan -->
<div class="flex gap-6 relative h-full" x-data="{ rightSidebarOpen: true }">

    <!-- ================= KONTEN UTAMA (DI TENGAH - Menyesuaikan Lebar) ================= -->
    <div class="flex-1 space-y-6 transition-all duration-300">

        <!-- Baris Tombol Toggle Sidebar Kanan -->
        <div class="flex justify-between items-center bg-white px-6 py-3 rounded-2xl border border-slate-200/80 shadow-sm">
            <div>
                <h2 class="font-bold text-slate-800 text-sm">Dashboard Overview</h2>
                <p class="text-[11px] text-slate-500">Kelola dan pantau aktivitas kelas dengan mudah.</p>
            </div>
            <button @click="rightSidebarOpen = !rightSidebarOpen" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-2">
                <span x-text="rightSidebarOpen ? '>' : '<'"></span>
            </button>
        </div>

        <!-- Banner Sambutan -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="relative z-10">
                <span class="bg-white/20 text-white text-[10px] font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-md">Dashboard Utama</span>
                <h1 class="text-2xl md:text-3xl font-bold mt-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-blue-100 text-xs md:text-sm mt-1 max-w-lg">Pusat informasi member kelas, daftar penghargaan, dan data guru pengajar yang terkelola rapi.</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 text-center shrink-0 relative z-10">
                <span class="block text-2xl font-bold">{{ isset($siswas) ? count($siswas) : 0 }}</span>
                <span class="text-[10px] text-blue-100 uppercase tracking-widest font-medium">Total Siswa Kelas</span>
            </div>
        </div>

        <!-- WIDGET QUOTES INTERNET (DI ATAS - UNLIMITED & RANDOM DARI INTERNET) -->
        <div class="rounded-3xl p-6 shadow-md border text-white transition-all duration-500 my-4"
             :class="currentBg"
             x-data="{
                 quote: 'Memuat quote dari internet...',
                 author: 'Mohon tunggu',
                 bgList: [
                     'bg-gradient-to-r from-blue-600 to-indigo-600 border-blue-400/30',
                     'bg-gradient-to-r from-purple-600 to-pink-600 border-purple-400/30',
                     'bg-gradient-to-r from-emerald-600 to-teal-600 border-emerald-400/30',
                     'bg-gradient-to-r from-amber-600 to-orange-600 border-amber-400/30',
                     'bg-gradient-to-r from-slate-900 to-indigo-950 border-slate-800'
                 ],
                 currentBg: '',
                 fetchQuote() {
                     this.currentBg = this.bgList[Math.floor(Math.random() * this.bgList.length)];
                     fetch('https://api.quotable.io/random')
                         .then(response => response.json())
                         .then(data => {
                             this.quote = data.content;
                             this.author = data.author;
                         })
                         .catch(error => {
                             this.quote = 'Pendidikan adalah senjata paling ampuh untuk mengubah dunia.';
                             this.author = 'Nelson Mandela';
                         });
                 }
             }"
             x-init="fetchQuote()">

            <div class="flex justify-between items-center">
                <span class="text-[10px] bg-white/20 text-white font-bold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-md">💡 Quote Internet (Unlimited)</span>
                <button @click="fetchQuote()" class="text-[11px] text-white hover:bg-white/20 transition flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur-md font-semibold">
                    🔄 Ganti Quote & Warna
                </button>
            </div>

            <blockquote class="text-xs md:text-sm italic text-slate-100 mt-4 font-medium">
                "<span x-text="quote"></span>"
            </blockquote>

            <div class="text-right pt-3 mt-3 border-t border-white/10">
                <span class="text-xs font-bold text-blue-200" x-text="'- ' + author"></span>
            </div>
        </div>

        <!-- 1. PENGHARGAAN KELAS -->
        <div class="space-y-3">
            <div class="flex justify-between items-center px-1">
                <h2 class="font-bold text-slate-900 text-base">🏆 Penghargaan Kelas</h2>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('prestasi.create') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 bg-white border border-slate-200 px-3.5 py-1.5 rounded-xl shadow-sm transition inline-block">+ Tambah Penghargaan</a>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if(isset($prestasis) && count($prestasis) > 0)
                    @foreach($prestasis as $prestasi)
                        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] bg-amber-100 text-amber-700 font-bold px-2.5 py-0.5 rounded-full">{{ $prestasi->kategori ?? 'Penghargaan' }}</span>
                                <h3 class="font-bold text-sm text-slate-900 mt-2">{{ $prestasi->nama_prestasi }}</h3>
                                <p class="text-[11px] text-slate-500 mt-1">{{ $prestasi->deskripsi ?? '-' }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-gradient-to-br from-indigo-900 to-slate-900 text-white rounded-3xl p-5 shadow-md flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] bg-amber-400 text-slate-950 font-bold px-2.5 py-0.5 rounded-full">Juara 1</span>
                            <h3 class="font-bold text-sm mt-2">Lomba Kebersihan Antar Kelas 2026</h3>
                            <p class="text-[11px] text-slate-300 mt-1">Prestasi tingkat sekolah menengah.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- 2. DAFTAR MEMBER KELAS -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-slate-900 text-base">👥 Daftar Siswa Kelas</h2>
                    <p class="text-xs text-slate-500">Anggota aktif terurut otomatis berdasarkan nomor absen (abjad nama).</p>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('siswa.create') }}" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md transition inline-block">+ Tambah Siswa</a>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-3 rounded-l-xl w-16 text-center">Absen</th>
                            <th class="p-3">Nama</th>
                            <th class="p-3">NISN</th>
                            <th class="p-3">Alamat</th>
                            <th class="p-3">Gender</th>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <th class="p-3 text-right rounded-r-xl">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @if(isset($siswas) && count($siswas) > 0)
                            @foreach($siswas as $siswa)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3 text-center">
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-blue-50 text-blue-600 font-bold rounded-xl text-xs border border-blue-100">
                                            {{ $siswa->absen ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="p-3 font-medium text-slate-800 flex items-center gap-3">
                                        @if($siswa->foto)
                                            <img src="{{ asset($siswa->foto) }}" alt="Foto" class="w-9 h-9 rounded-xl object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($siswa->nama_siswa ?? 'S', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-slate-800">{{ $siswa->nama_siswa }}</p>
                                            <p class="text-[10px] text-slate-400">{{ $siswa->email }}</p>
                                        </div>
                                    </td>
                                    <td class="p-3 text-slate-600 font-medium">{{ $siswa->nisn ?? '-' }}</td>
                                    <td class="p-3 text-slate-600 font-medium">{{ $siswa->alamat ?? '-' }}</td>
                                    <td class="p-3 text-slate-600 font-medium">{{ $siswa->jenis_kelamin ?? '-' }}</td>
                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                        <td class="p-3 text-right space-x-1">
                                            <a href="{{ route('siswa.edit', $siswa->id) }}" class="px-2.5 py-1 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg font-medium">Edit</a>
                                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="{{ (auth()->check() && auth()->user()->role === 'admin') ? 6 : 5 }}" class="p-6 text-center text-slate-400 italic">Belum ada data siswa.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. GURU PENGAJAR -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-slate-900 text-base">📚 Guru Pengajar</h2>
                    <p class="text-xs text-slate-500">Daftar pengajar mata pelajaran di kelas.</p>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('guru.create') }}" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md transition inline-block">+ Tambah Guru</a>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @if(isset($gurus) && count($gurus) > 0)
                    @foreach($gurus as $guru)
                        <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-100 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($guru->nama_guru ?? 'G', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-xs text-slate-800">{{ $guru->nama_guru }}</p>
                                    <p class="text-[10px] text-slate-500">{{ $guru->mata_pelajaran ?? 'Pengajar' }}</p>
                                </div>
                            </div>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <a href="{{ route('guru.edit', $guru->id) }}" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg text-[11px] font-semibold transition">Edit</a>
                                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-[11px] font-semibold transition">Hapus</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="col-span-2 p-6 text-center text-slate-400 italic text-xs">
                        Belum ada data guru pengajar.
                    </div>
                @endif
            </div>
        </div>

        <!-- 4. WIDGET FAKTA MENARIK & WAWASAN (POSISI DI PALING BAWAH - WARNA PASTEL 1 WARNA & INFORMASI LENGKAP) -->
        <div class="bg-emerald-50 border border-emerald-200/80 rounded-3xl p-6 shadow-sm space-y-3 my-4"
             x-data="{
                 funFact: 'Memuat wawasan menarik...',
                 factsList: [
                     'Tahukah kamu? Cahaya matahari yang kita lihat dan rasakan setiap hari di bumi sebenarnya membutuhkan waktu sekitar 8 menit 20 detik untuk menempuh perjalanan luar angkasa sejauh 150 juta kilometer sebelum akhirnya sampai ke permukaan bumi.',
                     'Tahukah kamu? Lidah manusia ternyata memiliki keunikan yang mirip seperti sidik jari tangan. Setiap orang di dunia ini memiliki pola cetakan dan tekstur garis lidah yang sepenuhnya berbeda satu sama lain.',
                     'Tahukah kamu? Secara klasifikasi botani ilmiah, buah pisang ternyata termasuk ke dalam kategori buah berry karena tumbuh dari bunga dengan ovarium tunggal. Sebaliknya, buah stroberi justru bukan termasuk buah berry.',
                     'Tahukah kamu? Madu murni adalah satu-satunya jenis makanan alami di bumi yang memiliki ketahanan luar biasa dan tidak akan pernah basi atau membusuk meskipun disimpan selama ribuan tahun.',
                     'Tahukah kamu? Dalam hal kekuatan fisik berdasarkan rasio ukuran otot, otot rahang manusia memegang rekor sebagai salah satu otot terkuat yang mampu menghasilkan kekuatan gigitan hingga ratusan kilogram.',
                     'Tahukah kamu? Planet Venus memiliki keunikan arah rotasi yang berlawanan dengan sebagian besar planet lain di tata surya kita. Di Venus, matahari terbit di sebelah barat dan terbenam di sebelah timur.'
                 ],
                 fetchFact() {
                     this.funFact = this.factsList[Math.floor(Math.random() * this.factsList.length)];
                 }
             }"
             x-init="fetchFact()">

            <div class="flex justify-between items-center">
                <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-full uppercase tracking-wider">🧠 Wawasan & Fakta Menarik</span>
                <button @click="fetchFact()" class="text-[11px] text-emerald-700 hover:bg-emerald-200/60 transition flex items-center gap-1.5 bg-emerald-100/70 px-3 py-1.5 rounded-xl font-semibold">
                    🔄 Fakta Lainnya
                </button>
            </div>

            <p class="text-xs md:text-sm text-emerald-900 font-medium leading-relaxed" x-text="funFact"></p>
        </div>

    </div>

    <!-- ================= SIDEBAR KANAN ================= -->
    <div x-show="rightSidebarOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0"
         class="w-80 shrink-0 space-y-6">

        @php
            $user = auth()->user();
            $isAdmin = $user && $user->role === 'admin';
            $siswaLogin = !$isAdmin && $user ? \App\Models\Siswa::where('email', $user->email)->first() : null;

            $totalSiswa = isset($siswas) ? count($siswas) : 0;
            $persenHadir = 0;

            if ($isAdmin) {
                $angkaStatistik = $totalSiswa;
                $labelStatistik = 'Siswa';

                $totalAbsenKelas = \App\Models\Absensi::count();
                if ($totalAbsenKelas > 0) {
                    $totalHadirKelas = \App\Models\Absensi::where('status', 'Hadir')->count();
                    $persenHadir = round(($totalHadirKelas / $totalAbsenKelas) * 100);
                } else {
                    $persenHadir = 100;
                }
            } else {
                $angkaStatistik = ($totalSiswa > 0) ? $totalSiswa - 1 : 0;
                $labelStatistik = 'Teman';

                if ($siswaLogin) {
                    $absenSiswa = \App\Models\Absensi::where('user_id', $user->id)->get();
                    $totalAbsenSiswa = $absenSiswa->count();

                    if ($totalAbsenSiswa > 0) {
                        $hadirSiswa = $absenSiswa->where('status', 'Hadir')->count();
                        $persenHadir = round(($hadirSiswa / $totalAbsenSiswa) * 100);
                    } else {
                        $persenHadir = 100;
                    }
                }
            }

            $totalTugas = isset($tugasList) ? count($tugasList) : \App\Models\Tugas::count();
        @endphp

        <!-- CARD PROFIL -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm text-center">
            @if($siswaLogin && $siswaLogin->foto)
                <img src="{{ asset($siswaLogin->foto) }}" alt="Foto" class="w-20 h-20 rounded-full object-cover mx-auto shadow-md border border-slate-200">
            @else
                <div class="w-20 h-20 bg-gradient-to-tr from-blue-600 to-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-2xl mx-auto shadow-md">
                    {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
                </div>
            @endif

            <h3 class="font-bold text-slate-900 text-base mt-4">{{ auth()->user()->name ?? 'User' }}</h3>
            <span class="inline-block bg-blue-50 text-blue-600 text-[10px] font-semibold px-3 py-1 rounded-full uppercase mt-1 border border-blue-100">
                {{ auth()->user()->role ?? 'Siswa' }}
            </span>
            <p class="text-xs text-slate-500 mt-2">
                @if($siswaLogin)
                    Absen: {{ $siswaLogin->absen }} | NISN: {{ $siswaLogin->nisn }}
                @else
                    Akun aktif terverifikasi.
                @endif
            </p>

            <div class="mt-5 pt-4 border-t border-slate-100 grid grid-cols-3 gap-2 items-center text-center">
                <div>
                    <span class="block font-bold text-slate-800 text-sm">{{ $angkaStatistik }}</span>
                    <span class="text-[10px] text-slate-400 uppercase">{{ $labelStatistik }}</span>
                </div>
                <div>
                    <span class="block font-bold text-slate-800 text-sm">{{ $totalTugas }}</span>
                    <span class="text-[10px] text-slate-400 uppercase">Tugas</span>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <div class="relative w-10 h-10 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-slate-100" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                            <path class="text-blue-600" stroke-dasharray="{{ $persenHadir }}, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                        </svg>
                        <div class="absolute text-[10px] font-bold text-slate-800">{{ $persenHadir }}%</div>
                    </div>
                    <span class="text-[10px] text-slate-400 uppercase mt-0.5">Kehadiran</span>
                </div>
            </div>
        </div>

        <!-- Widget Kalender Interaktif (Data dari PHP / Blade) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4"
             x-data="classCalendar(@js($tugasList ?? []))"
             x-init="initCalendar()">

            <div class="flex justify-between items-center">
                <h3 class="font-bold text-slate-900 text-sm" x-text="'📅 ' + monthNames[month] + ' ' + year"></h3>
                <div class="flex gap-1">
                    <button @click="changeMonth(-1)" class="p-1 hover:bg-slate-100 rounded-lg text-slate-600 text-xs font-bold">‹</button>
                    <button @click="changeMonth(1)" class="p-1 hover:bg-slate-100 rounded-lg text-slate-600 text-xs font-bold">›</button>
                </div>
            </div>

            <div class="grid grid-cols-7 text-center text-[11px] font-medium text-slate-400">
                <span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
            </div>

            <div class="grid grid-cols-7 text-center text-xs gap-y-2 text-slate-600">
                <template x-for="date in blankDays">
                    <div></div>
                </template>

                <template x-for="date in daysInMonth" :key="date">
                    <div @click="selectDate(date)"
                         class="relative py-1.5 rounded-xl cursor-pointer transition flex flex-col items-center justify-center"
                         :class="{
                             'bg-blue-600 text-white font-bold shadow-sm': isSelected(date),
                             'bg-blue-50 text-blue-600 font-bold border border-blue-100': isToday(date) && !isSelected(date),
                             'hover:bg-slate-100 text-slate-700': !isSelected(date) && !isToday(date)
                         }">
                        <span x-text="date" class="text-xs"></span>
                        <span x-show="hasTask(date)"
                              class="absolute bottom-0.5 w-1 h-1 rounded-full"
                              :class="isSelected(date) ? 'bg-white' : 'bg-red-500'"></span>
                    </div>
                </template>
            </div>

            <div class="pt-3 border-t border-slate-100 space-y-2">
                <div class="text-[11px] font-bold text-slate-700">
                    📌 Tugas pada <span x-text="selectedDateFormatted"></span>:
                </div>
                <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                    <template x-for="task in selectedTasks" :key="task.id">
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl text-left space-y-1.5">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-blue-600 uppercase" x-text="task.mapel ? task.mapel.nama_mapel : 'Umum'"></span>
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-md bg-amber-100 text-amber-700" x-text="task.deadline"></span>
                            </div>
                            <div class="text-xs font-semibold text-slate-800" x-text="task.judul_tugas"></div>
                        </div>
                    </template>
                    <template x-if="selectedTasks.length === 0">
                        <div class="text-[11px] text-slate-400 italic py-1">Tidak ada deadline tugas pada tanggal ini.</div>
                    </template>
                </div>
            </div>
        </div>

    </div>

</div>

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

            initCalendar() {
                this.getDays();
            },

            getDays() {
                let days = new Date(this.year, this.month + 1, 0).getDate();
                let startDay = new Date(this.year, this.month, 1).getDay();
                let adjustedStartDay = startDay === 0 ? 6 : startDay - 1;

                this.blankDays = Array.from({ length: adjustedStartDay });
                this.daysInMonth = Array.from({ length: days }, (_, i) => i + 1);
            },

            changeMonth(val) {
                if (this.month + val > 11) {
                    this.month = 0;
                    this.year++;
                } else if (this.month + val < 0) {
                    this.month = 11;
                    this.year--;
                } else {
                    this.month += val;
                }
                this.getDays();
            },

            isToday(date) {
                const today = new Date();
                return date === today.getDate() && this.month === today.getMonth() && this.year === today.getFullYear();
            },

            isSelected(date) {
                return date === this.selectedDay;
            },

            selectDate(date) {
                this.selectedDay = date;
            },

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

            get selectedDateFormatted() {
                return `${this.selectedDay} ${this.monthNames[this.month]} ${this.year}`;
            }
        }
    }
</script>
@endsection
