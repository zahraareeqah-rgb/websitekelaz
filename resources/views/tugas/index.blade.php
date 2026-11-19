@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-6">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-6 md:p-8 text-white shadow-lg flex justify-between items-center">
        <div>
            <span class="bg-white/20 text-white text-[10px] font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-md">Manajemen Tugas</span>
            <h1 class="text-2xl font-bold mt-2">Daftar Tugas Kelas</h1>
            <p class="text-blue-100 text-xs mt-1">Pantau tenggat waktu (deadline) tugas mata pelajaran dan guru pengajar.</p>
        </div>
        <!-- Tombol Tambah Tugas hanya untuk Admin -->
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('tugas.create') }}" class="px-4 py-2.5 bg-white text-blue-600 hover:bg-blue-50 rounded-2xl text-xs font-bold shadow transition">+ Tambah Tugas</a>
        @endif
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-3 rounded-l-xl">Mata Pelajaran</th>
                        <th class="p-3">Guru Pengajar</th> <!-- Kolom Baru Guru -->
                        <th class="p-3">Judul Tugas</th>
                        <th class="p-3">Deadline & Live Countdown</th>
                        <th class="p-3">Status</th>
                        <!-- Kolom Aksi hanya muncul untuk Admin -->
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <th class="p-3 text-right rounded-r-xl">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tugas as $item)
                        <tr class="hover:bg-slate-50/50 transition"
                            x-data="countdown('{{ $item->deadline }}')"
                            x-init="init()">

                            <td class="p-3 font-bold text-slate-800">{{ $item->mapel->nama_mapel ?? '-' }}</td>

                            <!-- Menampilkan Nama Guru Pengajar -->
                            <td class="p-3 text-slate-700 font-medium">
                                {{ $item->guru->nama_guru ?? '-' }}
                            </td>

                            <td class="p-3 text-slate-700 font-semibold">{{ $item->judul_tugas }}</td>

                            <!-- Kolom Live Countdown -->
                            <td class="p-3">
                                <div class="font-bold text-slate-800">📅 {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</div>
                                <div class="text-[10px] mt-0.5 font-semibold"
                                     :class="isExpired ? 'text-red-500' : 'text-amber-600'"
                                     x-text="timeLeft">
                                </div>
                            </td>

                            <td class="p-3">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg font-medium text-[10px]">
                                    {{ $item->status ?? 'Aktif' }}
                                </span>
                            </td>

                            <!-- Tombol Edit & Hapus hanya muncul untuk Admin -->
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <td class="p-3 text-right space-x-1">
                                    <a href="{{ route('tugas.edit', $item->id) }}" class="px-2.5 py-1 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg font-medium">Edit</a>
                                    <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium">Hapus</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ (auth()->check() && auth()->user()->role === 'admin') ? 6 : 5 }}" class="p-6 text-center text-slate-400 italic">Belum ada tugas yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script Alpine.js untuk Live Countdown -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('countdown', (deadline) => ({
            timeLeft: '',
            isExpired: false,
            init() {
                const targetTime = new Date(deadline + 'T23:59:59').getTime();

                const updateTimer = () => {
                    const now = new Date().getTime();
                    const distance = targetTime - now;

                    if (distance < 0) {
                        this.timeLeft = '⏳ Waktu deadline sudah lewat';
                        this.isExpired = true;
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    this.timeLeft = `⏳ ${days} hari ${hours} jam ${minutes} mnt ${seconds} dtk lagi`;
                    this.isExpired = false;
                };

                updateTimer();
                setInterval(updateTimer, 1000);
            }
        }));
    });
</script>
@endsection
