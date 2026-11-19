@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Judul -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex justify-between items-center">
        <div>
            <h1 class="font-bold text-slate-900 text-lg">📒 Catatan Pribadi</h1>
            <p class="text-xs text-slate-500">Simpan catatan, ide, atau pengingat penting milik akunmu secara aman dan privat.</p>
        </div>
    </div>

    <!-- Form Tambah Catatan -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <h2 class="font-bold text-slate-800 text-sm">➕ Tambah Catatan Baru</h2>

        <form action="{{ route('catatan.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Judul Catatan</label>
                <input type="text" name="judul" required placeholder="Contoh: Belajar Laravel Eloquent..."
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 font-medium text-slate-800">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Isi Catatan</label>
                <textarea name="isi_catatan" rows="3" required placeholder="Tulis catatan atau hal penting di sini..."
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 font-medium text-slate-800"></textarea>
            </div>

            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md transition">
                Simpan Catatan
            </button>
        </form>
    </div>

    <!-- Daftar Catatan Pribadi -->
    <div class="space-y-4">
        <h2 class="font-bold text-slate-900 text-base px-1">📌 Daftar Catatan Saya</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if(isset($catatans) && count($catatans) > 0)
                @foreach($catatans as $catatan)
                    <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-3">
                        <div>
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-sm text-slate-900">{{ $catatan->judul }}</h3>
                                <span class="text-[10px] text-slate-400">{{ $catatan->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-600 mt-2 whitespace-pre-line">{{ $catatan->isi_catatan }}</p>
                        </div>

                        <div class="flex justify-end pt-3 border-t border-slate-100">
                            <form action="{{ route('catatan.destroy', $catatan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-2 bg-white rounded-3xl p-8 border border-slate-200/80 text-center text-slate-400 italic text-xs">
                    Belum ada catatan pribadi yang kamu buat.
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
