@extends('layouts.app')

@section('content')
<!-- Container Utama Fullscreen dengan Background Papan Tulis Kelas -->
<div class="relative min-h-screen -m-6 p-6 md:p-12 bg-cover bg-center bg-fixed text-white font-sans flex flex-col justify-between overflow-x-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');">

    <!-- Overlay Gelap Tipis & Natural -->
    <div class="absolute inset-0 bg-slate-950/45 backdrop-blur-[1px] z-0"></div>

    <div class="relative z-10 w-full max-w-2xl mx-auto space-y-8 pt-4 pb-16">

        <div class="bg-slate-900/85 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-8 border border-white/20 shadow-2xl space-y-6">
            <div class="flex items-center gap-2 border-b border-white/10 pb-4">
                <span class="text-xl">✏️</span>
                <h2 class="text-base font-bold text-white tracking-tight">Edit Catatan Pribadi</h2>
            </div>

            <form action="{{ route('catatan.update', $catatan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Input Judul -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Judul Catatan</label>
                    <input type="text" name="judul" value="{{ old('judul', $catatan->judul) }}" required
                           class="w-full bg-white/5 border border-white/15 rounded-2xl px-4 py-3 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-amber-400 transition">
                </div>

                <!-- Input Isi Catatan -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Isi Catatan</label>
                    <textarea name="isi_catatan" rows="5" required
                              class="w-full bg-white/5 border border-white/15 rounded-2xl p-4 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-amber-400 transition resize-none">{{ old('isi_catatan', $catatan->isi_catatan) }}</textarea>
                </div>

                <!-- Preview Foto Saat Ini (Mendukung Multi-Foto, Hapus Satuan, & Ganti Satuan) -->
                @php
                    $fotos = [];
                    if (!empty($catatan->foto)) {
                        if (is_array($catatan->foto)) {
                            $fotos = $catatan->foto;
                        } else {
                            $decoded = json_decode($catatan->foto, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                $fotos = $decoded;
                            } else {
                                $fotos = array_map('trim', explode(',', $catatan->foto));
                            }
                        }
                    }
                @endphp

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Lampiran Foto Saat Ini</label>
                    @if(count($fotos) > 0)
                        <div class="grid grid-cols-3 gap-3 mb-3">
                            @foreach($fotos as $index => $f)
                                <div class="relative rounded-2xl overflow-hidden border border-white/20 aspect-square bg-slate-950 group">
                                    <img src="{{ asset($f) }}" alt="Foto Catatan" class="w-full h-full object-cover">
                                    
                                    <!-- Overlay Aksi (Hapus atau Ganti per Foto saat Hover) -->
                                    <div class="absolute inset-0 bg-slate-950/75 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center p-2 gap-1.5 text-center">
                                        
                                        <!-- Checkbox Hapus Foto -->
                                        <label class="cursor-pointer flex items-center justify-center gap-1 bg-red-500/80 hover:bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-lg transition w-full">
                                            <input type="checkbox" name="hapus_foto[]" value="{{ $f }}" class="rounded border-white/30 text-red-600 focus:ring-0">
                                            Hapus
                                        </label>

                                        <!-- Input Ganti Foto Spesifik -->
                                        <label class="cursor-pointer flex items-center justify-center gap-1 bg-amber-500 hover:bg-amber-400 text-slate-950 text-[10px] font-extrabold px-2 py-1 rounded-lg transition w-full">
                                            <span>🔄 Ganti</span>
                                            <input type="file" name="ganti_foto[{{ $index }}]" accept="image/*" class="hidden">
                                        </label>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <span class="text-[10px] text-slate-400 block">Arahkan kursor ke foto untuk menghapus atau mengganti foto secara spesifik.</span>
                    @else
                        <p class="text-xs text-slate-400 italic">Belum ada foto yang dilampirkan pada catatan ini.</p>
                    @endif
                </div>

                <!-- Input Tambah Foto Baru (Multi-Upload) -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Tambah Foto Baru (Opsional)</label>
                    <label class="flex-1 cursor-pointer bg-white/5 border border-dashed border-white/20 hover:border-amber-400 rounded-2xl p-4 text-center transition flex flex-col items-center justify-center gap-1 group">
                        <span class="text-xl group-hover:scale-110 transition">📷</span>
                        <span class="text-xs text-slate-300 font-medium">Klik untuk pilih banyak foto baru (.jpg, .png)</span>
                        <input type="file" name="foto[]" accept="image/*" multiple class="hidden">
                    </label>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('catatan.index') }}" class="px-6 py-3.5 bg-white/10 hover:bg-white/20 text-slate-300 font-bold rounded-2xl text-xs transition">
                        Batal
                    </a>
                    <button type="submit" class="px-7 py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold rounded-2xl text-xs shadow-xl transition uppercase tracking-wider">
                        Perbarui Catatan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection