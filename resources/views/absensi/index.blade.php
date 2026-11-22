@extends('layouts.app')

@section('content')

<div class="relative min-h-screen -m-6 p-6 md:p-12 bg-cover bg-center bg-fixed text-white font-sans flex flex-col justify-between overflow-x-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');">

    <div class="absolute inset-0 bg-slate-950/45 backdrop-blur-[1px] z-0"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto space-y-10 pt-4 pb-16" x-data="{ loading: false }">

    <!-- HERO SECTION (Header Banner) -->
    <div class="bg-gradient-to-br from-slate-900/80 via-emerald-950/50 to-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-10 text-white shadow-2xl border border-white/20 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-2">
            <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] font-extrabold px-3.5 py-1 rounded-full uppercase tracking-widest backdrop-blur-md">
                Rekapitulasi Kehadiran
            </span>
            <h1 class="text-3xl md:text-4xl font-black tracking-tight text-white">Absensi Bulanan Kelas</h1>
            <p class="text-slate-300 text-xs md:text-sm max-w-xl font-medium">
                @if(auth()->user()->role === 'admin')
                    Gunakan tombol cepat di kolom nama untuk rekap sebulan, atau klik kotak tanggal untuk ubah satuan.
                @else
                    Pantau kehadiran harian seluruh member kelas secara matriks.
                @endif
            </p>
        </div>

        <!-- FILTER BULAN DAN TAHUN -->
        <form method="GET" action="{{ route('absensi.index') }}" class="relative z-10 flex items-center gap-2 bg-slate-900/50 backdrop-blur-md p-2 rounded-2xl border border-white/20">
            <select name="bulan" class="bg-slate-800 text-slate-100 text-xs font-semibold px-3 py-2 rounded-xl border border-white/10 focus:outline-none shadow-sm">
                @php
                    $months = [
                        '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
                        '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
                        '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                    ];
                @endphp
                @foreach($months as $key => $name)
                    <option value="{{ $key }}" {{ (int)$bulan === (int)$key ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>

            <select name="tahun" class="bg-slate-800 text-slate-100 text-xs font-semibold px-3 py-2 rounded-xl border border-white/10 focus:outline-none shadow-sm">
                @php $currentYear = now()->year; @endphp
                @for($y = $currentYear - 3; $y <= $currentYear + 2; $y++)
                    <option value="{{ $y }}" {{ (int)$tahun === $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            <button type="submit" class="bg-emerald-500 text-slate-950 px-4 py-2 rounded-xl text-xs font-extrabold shadow-lg hover:bg-emerald-400 transition">Filter</button>
        </form>
    </div>

    <!-- TABEL MATRIKS ABSENSI -->
    <div class="bg-slate-900/65 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-8 border border-white/20 shadow-2xl space-y-6 relative pb-10 w-full">

        <!-- Loading Indicator -->
        <div x-show="loading" class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm z-30 flex items-center justify-center rounded-[2.5rem]">
            <span class="text-xs font-bold text-emerald-300 animate-pulse">Menyimpan Rekapitulasi...</span>
        </div>

        <div class="flex justify-between items-center flex-wrap gap-2">
            <h3 class="font-bold text-white text-sm">
                📅 Rekap Tanggal (1 - {{ $daysInMonth }})
            </h3>
            <span class="text-xs text-slate-400 italic">
                @if(auth()->user()->role === 'admin') 💡 Klik tombol "Hadir 1 Bln" di bawah nama siswa untuk isi instan sebulan penuh. @endif
            </span>
        </div>

        <!-- Wrapper Tabel dengan Overflow Auto -->
        <div class="w-full overflow-x-auto pt-2 pb-4">
            <table class="w-full text-left text-xs text-slate-200 border-collapse">
                <thead class="bg-white/10 text-slate-300 uppercase tracking-wider text-[10px] border-b border-white/15">
                    <tr>
                        <th class="p-3.5 bg-white/5 min-w-[280px] rounded-l-xl">Nama Siswa & Aksi Cepat</th>
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            <th class="p-2 text-center min-w-[36px] border-l border-white/10">{{ $d }}</th>
                        @endfor
                        <th class="p-3.5 text-center bg-white/10 font-bold min-w-[95px] border-l border-white/10 rounded-r-xl">H / S / I / A</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($siswas as $siswa)
                        @php
                            $user = \App\Models\User::where('email', $siswa->email)->first();
                            $userIdReal = $user ? $user->id : null;

                            $userAbsens = $userIdReal && isset($absensis[$userIdReal]) ? $absensis[$userIdReal] : collect();
                            $attendanceByDate = $userAbsens->keyBy(fn($item) => \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d'));

                            $hadir = $userAbsens->where('status', 'Hadir')->count();
                            $sakit = $userAbsens->where('status', 'Sakit')->count();
                            $izin  = $userAbsens->where('status', 'Izin')->count();
                            $alpa  = $userAbsens->where('status', 'Alpa')->count();

                            $totalAbsenSiswa = $userAbsens->count();
                            $persenSiswa = 100;
                            if ($totalAbsenSiswa > 0) {
                                $totalPoinSiswa = ($hadir * 1.0) + ($sakit * 0.5) + ($izin * 0.5);
                                $persenSiswa = round(($totalPoinSiswa / $totalAbsenSiswa) * 100);
                            }
                        @endphp

                        <tr class="hover:bg-white/5 transition">
                            <!-- Kolom Nama Siswa & Tombol Rekap Cepat -->
                            <td class="p-3.5 bg-slate-900/20">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2.5 overflow-hidden">
                                        <div class="w-7 h-7 bg-emerald-500/20 text-emerald-300 rounded-lg flex items-center justify-center font-bold text-[10px] shrink-0 border border-emerald-400/30">
                                            {{ $siswa->absen }}
                                        </div>
                                        <span class="font-bold text-white text-xs" title="{{ $siswa->nama_siswa }}">{{ $siswa->nama_siswa }}</span>
                                    </div>

                                    @if(auth()->user()->role === 'admin' && $userIdReal)
                                        <button type="button" 
                                                @click="rekapBulan('{{ $userIdReal }}', '{{ $tahun }}', '{{ $bulan }}', 'Hadir')"
                                                class="px-2.5 py-1 bg-emerald-500/20 hover:bg-emerald-500 hover:text-slate-950 text-emerald-300 border border-emerald-400/40 rounded-lg text-[9px] font-extrabold uppercase transition shrink-0"
                                                title="Isi Hadir semua tanggal di bulan ini">
                                            ⚡ Hadir 1 Bln
                                        </button>
                                    @endif
                                </div>
                            </td>

                            @for($d = 1; $d <= $daysInMonth; $d++)
                                @php
                                    $currentDate = sprintf('%04d-%02d-%02d', $tahun, $bulan, $d);
                                    $absensiHariIni = $attendanceByDate->get($currentDate);

                                    $statusSymbol = '-';
                                    $badgeColor = 'text-slate-400 bg-white/10 border border-white/10 hover:bg-white/15';
                                    if ($absensiHariIni) {
                                        switch ($absensiHariIni->status) {
                                            case 'Hadir': $statusSymbol = 'H'; $badgeColor = 'bg-emerald-100 text-emerald-700 font-bold shadow-sm'; break;
                                            case 'Sakit': $statusSymbol = 'S'; $badgeColor = 'bg-amber-100 text-amber-700 font-bold shadow-sm'; break;
                                            case 'Izin':  $statusSymbol = 'I'; $badgeColor = 'bg-blue-100 text-blue-700 font-bold shadow-sm'; break;
                                            case 'Alpa':  $statusSymbol = 'A'; $badgeColor = 'bg-red-100 text-red-700 font-bold shadow-sm'; break;
                                        }
                                    }
                                @endphp

                                <td class="p-1.5 text-center border-l border-white/10 relative" x-data="{ openMenu: false }">
                                    @if(auth()->user()->role === 'admin' && $userIdReal)
                                        <button type="button"
                                                @click="openMenu = !openMenu"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-[11px] transition cursor-pointer {{ $badgeColor }}"
                                                title="Tanggal {{ $currentDate }} - Klik untuk ubah">
                                            {{$statusSymbol}}
                                        </button>

                                        <div x-show="openMenu"
                                             @click.outside="openMenu = false"
                                             class="absolute z-50 mt-2 left-1/2 -translate-x-1/2 w-36 bg-white rounded-2xl shadow-2xl border border-slate-200 py-2 text-left text-xs font-semibold text-slate-700"
                                             style="display: none;">
                                            <div class="px-3 py-1.5 text-[10px] text-slate-400 border-b border-slate-100 font-bold text-center bg-slate-50 rounded-t-xl mb-1">{{ $currentDate }}</div>

                                            <button type="button" @click="openMenu = false; updateStatus('{{ $userIdReal }}', '{{ $currentDate }}', 'Hadir')" class="w-full px-3.5 py-2 hover:bg-emerald-50 text-emerald-700 flex items-center gap-2.5 transition">🟢 Hadir (H)</button>
                                            <button type="button" @click="openMenu = false; updateStatus('{{ $userIdReal }}', '{{ $currentDate }}', 'Sakit')" class="w-full px-3.5 py-2 hover:bg-amber-50 text-amber-700 flex items-center gap-2.5 transition">🟡 Sakit (S)</button>
                                            <button type="button" @click="openMenu = false; updateStatus('{{ $userIdReal }}', '{{ $currentDate }}', 'Izin')" class="w-full px-3.5 py-2 hover:bg-blue-50 text-blue-700 flex items-center gap-2.5 transition">🔵 Izin (I)</button>
                                            <button type="button" @click="openMenu = false; updateStatus('{{ $userIdReal }}', '{{ $currentDate }}', 'Alpa')" class="w-full px-3.5 py-2 hover:bg-red-50 text-red-700 flex items-center gap-2.5 transition">🔴 Alpa (A)</button>
                                            <button type="button" @click="openMenu = false; updateStatus('{{ $userIdReal }}', '{{ $currentDate }}', 'Hapus')" class="w-full px-3.5 py-2 hover:bg-slate-100 text-slate-400 border-t border-slate-100 mt-1 flex items-center gap-2.5 transition">🧹 Kosongkan</button>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-[11px] {{ $badgeColor }}">
                                            {{ $statusSymbol }}
                                        </span>
                                    @endif
                                </td>
                            @endfor

                            <!-- RINGKASAN TOTAL -->
                            <td class="p-3 text-center font-semibold bg-white/5 whitespace-nowrap border-l border-white/10" title="Persentase Kehadiran Poin: {{ $persenSiswa }}%">
                                <span class="text-emerald-400 font-bold" title="Hadir">{{ $hadir }}</span>/<span class="text-amber-400 font-bold" title="Sakit">{{ $sakit }}</span>/<span class="text-blue-400 font-bold" title="Izin">{{ $izin }}</span>/<span class="text-red-400 font-bold" title="Alpa">{{ $alpa }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $daysInMonth + 2 }}" class="p-8 text-center text-slate-400 italic">Belum ada data siswa terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- KETERANGAN STATUS -->
        <div class="flex flex-wrap items-center gap-4 pt-4 mt-4 border-t border-white/10 text-[11px] text-slate-300 font-medium">
            <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-bold">H</span> Hadir</span>
            <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold">I</span> Izin</span>
            <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded bg-amber-100 text-amber-700 flex items-center justify-center text-[10px] font-bold">S</span> Sakit</span>
            <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded bg-red-100 text-red-700 flex items-center justify-center text-[10px] font-bold">A</span> Alpa</span>
            <span class="text-slate-400 ml-auto">Format Ringkasan: (Hadir / Sakit / Izin / Alpa)</span>
        </div>
    </div>
    </div>
</div>

<script>
function updateStatus(userId, tanggal, status) {
    const alpineRoot = document.querySelector('[x-data]');
    if (alpineRoot && alpineRoot.__x) {
        alpineRoot.__x.$data.loading = true;
    }

    fetch('{{ route('absensi.updateCepat') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            user_id: userId,
            tanggal: tanggal,
            status: status
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
            location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        location.reload();
    });
}

function rekapBulan(userId, tahun, bulan, status) {
    if (!confirm('Yakin ingin mengisi status ' + status + ' untuk siswa ini sepanjang bulan ' + bulan + '/' + tahun + '?')) {
        return;
    }

    const alpineRoot = document.querySelector('[x-data]');
    if (alpineRoot && alpineRoot.__x) {
        alpineRoot.__x.$data.loading = true;
    }

    fetch('{{ route('absensi.rekapBulan') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            user_id: userId,
            tahun: tahun,
            bulan: bulan,
            status: status
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
            location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        location.reload();
    });
}
</script>

@endsection