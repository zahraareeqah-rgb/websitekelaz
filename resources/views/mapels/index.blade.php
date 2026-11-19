@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-6">
    <!-- Banner Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-6 md:p-8 text-white shadow-lg flex justify-between items-center">
        <div>
            <span class="bg-white/20 text-white text-[10px] font-semibold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-md">Kelola Akademik</span>
            <h1 class="text-2xl font-bold mt-2">Daftar Mata Pelajaran</h1>
            <p class="text-blue-100 text-xs mt-1">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    Kelola data mata pelajaran yang diajarkan di kelas.
                @else
                    Daftar mata pelajaran yang aktif di kelas.
                @endif
            </p>
        </div>

        <!-- Tombol Tambah Mapel (Hanya untuk Admin) -->
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('mapel.create') }}" class="px-4 py-2.5 bg-white text-blue-600 hover:bg-blue-50 rounded-2xl text-xs font-bold shadow transition">+ Tambah Mapel</a>
        @endif
    </div>

    <!-- Tabel Data Mapel -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-3 rounded-l-xl">No</th>
                        <th class="p-3">Nama Mata Pelajaran</th>
                        <th class="p-3">Keterangan</th>

                        <!-- Kolom Aksi hanya muncul untuk Admin -->
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <th class="p-3 text-right rounded-r-xl">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mapels as $index => $mapel)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3 font-semibold text-slate-500">{{ $index + 1 }}</td>
                            <td class="p-3 font-bold text-slate-800">{{ $mapel->nama_mapel ?? $mapel->nama }}</td>
                            <td class="p-3 text-slate-500">{{ $mapel->keterangan ?? '-' }}</td>

                            <!-- Tombol Edit & Hapus hanya muncul untuk Admin -->
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <td class="p-3 text-right space-x-1">
                                    <a href="{{ route('mapel.edit', $mapel->id) }}" class="px-2.5 py-1 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg font-medium">Edit</a>
                                    <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus mapel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium">Hapus</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ (auth()->check() && auth()->user()->role === 'admin') ? 4 : 3 }}" class="p-6 text-center text-slate-400 italic">Belum ada mata pelajaran yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
