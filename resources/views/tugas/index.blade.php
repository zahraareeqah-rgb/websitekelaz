@extends('layouts.app')

@section('content')
<!-- Container Utama Fullscreen dengan Background Papan Tulis Kelas -->
<div class="relative min-h-screen -m-6 p-6 md:p-12 bg-cover bg-center bg-fixed text-white font-sans flex flex-col justify-between overflow-x-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');">

    <!-- Overlay Gelap Tipis & Natural -->
    <div class="absolute inset-0 bg-slate-950/45 backdrop-blur-[1px] z-0"></div>

    <!-- WRAPPER UTAMA -->
    <div class="relative z-10 w-full max-w-7xl mx-auto space-y-10 pt-4 pb-16"
         x-data="tugasFilterManager(@js($tugas ?? []))">

        <!-- ================= HERO SECTION (Header Banner) ================= -->
        <div class="bg-gradient-to-br from-slate-900/80 via-indigo-950/50 to-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-10 text-white shadow-2xl border border-white/20 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-2">
                <span class="bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 text-[10px] font-extrabold px-3.5 py-1 rounded-full uppercase tracking-widest backdrop-blur-md">
                    📋 Manajemen Tugas
                </span>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-white flex items-center gap-3">
                    Daftar Tugas Kelas
                    <span class="animate-bounce">🎯</span>
                </h1>
                <p class="text-slate-300 text-xs md:text-sm max-w-xl font-medium">
                    Pilih filter mata pelajaran di bawah untuk menyaring daftar tugas kelas secara instan.
                </p>
            </div>

            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="relative z-10">
                    <a href="{{ route('tugas.create') }}" class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl text-xs shadow-xl transition flex items-center gap-2 tracking-wider uppercase">
                        <span>+</span> Tambah Tugas Baru
                    </a>
                </div>
            @endif
        </div>

        <!-- ================= TOMBOL FILTER BERDASARKAN MATA PELAJARAN ================= -->
        @if(isset($tugas) && count($tugas) > 0)
            <div class="bg-slate-900/65 backdrop-blur-2xl rounded-3xl p-5 border border-white/20 shadow-2xl space-y-3">
                <div class="flex items-center justify-between px-1">
                    <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider">Pilih Kategori Mapel</span>
                    <span class="text-xs text-slate-300 font-medium" x-text="'Menampilkan ' + filteredTugas.length + ' dari ' + allTugas.length + ' tugas'"></span>
                </div>

                <!-- List Tombol Filter -->
                <div class="flex flex-wrap gap-2.5">
                    <button @click="selectedMapel = 'semua'"
                            class="px-4 py-2 rounded-2xl text-xs font-bold transition border shadow-md flex items-center gap-2"
                            :class="selectedMapel === 'semua' ? 'bg-emerald-500 text-slate-950 border-emerald-400 shadow-emerald-500/20 scale-105' : 'bg-white/10 text-slate-200 border-white/15 hover:bg-white/20'">
                        <span>✨ Semua Mapel</span>
                    </button>

                    <template x-for="mapel in uniqueMapels" :key="mapel">
                        <button @click="selectedMapel = mapel"
                                class="px-4 py-2 rounded-2xl text-xs font-bold transition border shadow-md flex items-center gap-2"
                                :class="selectedMapel === mapel ? 'bg-emerald-500 text-slate-950 border-emerald-400 shadow-emerald-500/20 scale-105' : 'bg-white/10 text-slate-200 border-white/15 hover:bg-white/20'">
                            <span x-text="'📚 ' + mapel"></span>
                        </button>
                    </template>
                </div>
            </div>
        @endif

        <!-- ================= TABEL DAFTAR TUGAS (DENGAN KOLOM DESKRIPSI & FILTER REAL-TIME) ================= -->
        <div class="bg-slate-900/65 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-8 border border-white/20 shadow-2xl space-y-6">
            <div class="flex justify-between items-center px-2">
                <div>
                    <h2 class="text-lg font-bold text-white tracking-tight">Daftar Tugas Aktif</h2>
                    <p class="text-xs text-slate-300">Tenggat waktu & indikator ekspresi darurat otomatis.</p>
                </div>
                <span class="px-3.5 py-1 bg-emerald-500/20 text-emerald-300 font-semibold text-xs rounded-full border border-emerald-400/30" x-text="filteredTugas.length + ' Tugas'"></span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-200">
                    <thead class="bg-white/10 text-slate-300 uppercase tracking-wider border-b border-white/15">
                        <tr>
                            <th class="p-4 rounded-l-2xl">Mata Pelajaran</th>
                            <th class="p-4">Guru Pengajar</th>
                            <th class="p-4">Judul Tugas & Deskripsi</th>
                            <th class="p-4">Deadline & Status Ekspresi</th>
                            <th class="p-4">Status</th>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <th class="p-4 text-right rounded-r-2xl">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        <template x-for="item in filteredTugas" :key="item.id">
                            <tr class="hover:bg-white/5 transition align-top">
                                <td class="p-4 font-bold text-emerald-300" x-text="item.mapel ? (item.mapel.nama_mapel || item.mapel.nama) : 'Umum'"></td>
                                <td class="p-4 font-medium text-slate-300" x-text="'👨‍🏫 ' + (item.guru ? item.guru.nama_guru : '-')"></td>
                                <td class="p-4 space-y-1">
                                    <div class="font-bold text-white text-sm" x-text="item.judul_tugas"></div>
                                    <div class="text-[11px] text-slate-300 font-normal leading-relaxed italic" x-text="item.deskripsi ? item.deskripsi : 'Tidak ada deskripsi tambahan.'"></div>
                                </td>

                                <!-- Kolom Deadline + Live Countdown & Emoji -->
                                <td class="p-4" x-data="urgencyChecker(item.deadline)" x-init="initTimer()">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-xl shadow-lg border border-white/20 shrink-0 transition-transform hover:scale-110"
                                             :class="badgeBg"
                                             :title="statusText">
                                            <span x-text="emoji"></span>
                                        </div>
                                        <div>
                                            <div class="font-bold text-white">
                                                <span x-text="'📅 ' + item.deadline"></span>
                                            </div>
                                            <div class="text-[11px] font-semibold mt-0.5" :class="textColor" x-text="countdownText"></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase border"
                                          :class="item.status && item.status.toLowerCase() === 'aktif' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-400/40' : 'bg-amber-500/20 text-amber-300 border-amber-400/40'"
                                          x-text="item.status || 'Aktif'">
                                    </span>
                                </td>

                                @if(auth()->check() && auth()->user()->role === 'admin')
                                    <td class="p-4 text-right space-x-1">
                                        <a :href="'/tugas/' + item.id + '/edit'" class="px-3.5 py-1.5 bg-amber-500/20 text-amber-300 border border-amber-400/30 hover:bg-amber-500/30 rounded-xl font-bold text-xs transition inline-block">Edit</a>
                                        <form :action="'/tugas/' + item.id" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3.5 py-1.5 bg-red-500/20 text-red-300 border border-red-400/30 hover:bg-red-500/30 rounded-xl font-bold text-xs transition">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        </template>

                        <!-- Tampilan Jika Data Filter Kosong -->
                        <template x-if="filteredTugas.length === 0">
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400 italic text-xs">
                                    Tidak ada tugas untuk mata pelajaran ini.
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- Script Alpine.js untuk Filter & Kalkulasi Emoji Ekspresi Otomatis -->
<script>
    function tugasFilterManager(tasksData) {
        return {
            allTugas: tasksData,
            selectedMapel: 'semua',
            get uniqueMapels() {
                let mapels = this.allTugas.map(t => {
                    if (!t.mapel) return null;
                    return t.mapel.nama_mapel || t.mapel.nama;
                }).filter(Boolean);
                return [...new Set(mapels)];
            },
            get filteredTugas() {
                if (this.selectedMapel === 'semua') {
                    return this.allTugas;
                }
                return this.allTugas.filter(t => {
                    if (!t.mapel) return false;
                    let namaMapel = t.mapel.nama_mapel || t.mapel.nama;
                    return namaMapel === this.selectedMapel;
                });
            }
        }
    }

    function urgencyChecker(deadlineStr) {
        return {
            deadline: new Date(deadlineStr).getTime(),
            emoji: '😎',
            statusText: 'Santai & Aman',
            badgeBg: 'bg-emerald-500/20 text-emerald-300',
            textColor: 'text-emerald-400',
            countdownText: 'Memuat waktu...',
            initTimer() {
                this.updateCountdown();
                setInterval(() => { this.updateCountdown(); }, 1000);
            },
            updateCountdown() {
                const now = new Date().getTime();
                const distance = this.deadline - now;

                if (distance < 0) {
                    this.emoji = '💀';
                    this.statusText = 'Deadline Telah Lewat!';
                    this.badgeBg = 'bg-red-500/30 text-red-300 border-red-500/50';
                    this.textColor = 'text-red-400 font-bold';
                    this.countdownText = 'Waktu habis / Terlewat';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                this.countdownText = `${days} hari ${hours} jam ${minutes} mnt ${seconds} dtk lagi`;

                // Diperbaiki menggunakan >= 7 agar pas 7 hari tetap sinkron ke emoji aman 😎
                if (days >= 7) {
                    this.emoji = '😎';
                    this.statusText = 'Aman banget (>= 1 minggu)';
                    this.badgeBg = 'bg-emerald-500/20 text-emerald-300';
                    this.textColor = 'text-emerald-400';
                } else if (days === 4) {
                    this.emoji = '🙂';
                    this.statusText = 'Masih biasa (4 hari lagi)';
                    this.badgeBg = 'bg-teal-500/20 text-teal-300';
                    this.textColor = 'text-teal-300';
                } else if (days === 3) {
                    this.emoji = '😅';
                    this.statusText = 'Mulai agak cemas (3 hari lagi)';
                    this.badgeBg = 'bg-yellow-500/20 text-yellow-300';
                    this.textColor = 'text-yellow-300';
                } else if (days === 2) {
                    this.emoji = '😵';
                    this.statusText = 'Pusing / Waktu mepet (2 hari lagi)';
                    this.badgeBg = 'bg-orange-500/20 text-orange-300';
                    this.textColor = 'text-orange-400';
                } else {
                    this.emoji = '😱';
                    this.statusText = 'Darurat / Besok kumpul! (<= 1 hari)';
                    this.badgeBg = 'bg-red-500/30 text-red-300 animate-pulse';
                    this.textColor = 'text-red-400 font-bold';
                }
            }
        }
    }
</script>
@endsection