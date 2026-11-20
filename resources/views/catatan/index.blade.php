@extends('layouts.app')

@section('content')
<!-- Container Utama Fullscreen dengan Background Papan Tulis Kelas -->
<div class="relative min-h-screen -m-6 p-6 md:p-12 bg-cover bg-center bg-fixed text-white font-sans flex flex-col justify-between overflow-x-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');">

    <!-- Overlay Gelap Tipis & Natural -->
    <div class="absolute inset-0 bg-slate-950/45 backdrop-blur-[1px] z-0"></div>

    <!-- WRAPPER UTAMA -->
    <div class="relative z-10 w-full max-w-5xl mx-auto space-y-10 pt-4 pb-16">

        <!-- ================= HERO / BANNER UTAMA ================= -->
        <div class="bg-gradient-to-br from-slate-900/80 via-amber-950/40 to-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-10 text-white shadow-2xl border border-white/20 relative overflow-hidden space-y-3">
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <span class="bg-amber-500/20 text-amber-300 border border-amber-400/30 text-[10px] font-extrabold px-3.5 py-1 rounded-full uppercase tracking-widest backdrop-blur-md inline-block">
                📒 Catatan Pribadi & Pengingat
            </span>
            <h1 class="text-3xl md:text-4xl font-black tracking-tight text-white flex items-center gap-3">
                Ruang Catatan Anda
                <span class="animate-bounce">✨</span>
            </h1>
            <p class="text-slate-300 text-xs md:text-sm max-w-xl font-medium">
                Simpan ide, rangkuman tugas, atau catatan penting milik akunmu secara aman dan privat lengkap dengan dokumentasi foto.
            </p>
        </div>

        <!-- ================= FORM TAMBAH CATATAN (DENGAN UPLOAD FOTO) ================= -->
        <div class="bg-slate-900/75 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-8 border border-white/20 shadow-2xl space-y-6">
            <div class="flex items-center gap-2 border-b border-white/10 pb-4">
                <span class="text-xl">➕</span>
                <h2 class="text-base font-bold text-white tracking-tight">Tambah Catatan Baru</h2>
            </div>

            <form action="{{ route('catatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Input Judul -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Judul Catatan</label>
                    <input type="text" name="judul" placeholder="Contoh: Rangkuman Tugas Pemrograman Web..." required
                           class="w-full bg-white/5 border border-white/15 rounded-2xl px-4 py-3 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-amber-400 transition">
                </div>

                <!-- Input Isi Catatan -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Isi Catatan</label>
                    <textarea name="isi_catatan" rows="4" placeholder="Tulis rincian catatan atau pengingat di sini..." required
                              class="w-full bg-white/5 border border-white/15 rounded-2xl p-4 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-amber-400 transition resize-none"></textarea>
                </div>

                <!-- Input Upload Foto -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Lampirkan Foto / Dokumentasi (Opsional)</label>
                    <div class="flex items-center gap-4">
                        <label class="flex-1 cursor-pointer bg-white/5 border border-dashed border-white/20 hover:border-amber-400 rounded-2xl p-4 text-center transition flex flex-col items-center justify-center gap-1 group">
                            <span class="text-xl group-hover:scale-110 transition">📷</span>
                            <span class="text-xs text-slate-300 font-medium">Klik untuk pilih foto catatan (.jpg, .png)</span>
                            <input type="file" name="foto" accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="pt-2">
                    <button type="submit" class="px-7 py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold rounded-2xl text-xs shadow-xl transition uppercase tracking-wider">
                        💾 Simpan Catatan Pribadi
                    </button>
                </div>
            </form>
        </div>

        <!-- ================= DAFTAR CATATAN SAYA ================= -->
        <div class="space-y-6">
            <div class="flex justify-between items-center px-2">
                <h2 class="text-lg font-bold text-white tracking-tight flex items-center gap-2">
                    <span>📌</span> Daftar Catatan Saya
                </h2>
                <span class="px-3.5 py-1 bg-white/10 text-amber-300 font-semibold text-xs rounded-full border border-white/20 backdrop-blur-md">
                    Total: {{ count($catatans ?? []) }} Catatan
                </span>
            </div>

            @if(isset($catatans) && count($catatans) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($catatans as $catatan)
                        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/20 shadow-2xl overflow-hidden flex flex-col justify-between group hover:border-amber-400/50 transition duration-300">

                            <!-- Bagian Foto yang Dipercantik (Rasio & Tampilan Proporsional) -->
                            @if($catatan->foto)
                                <div class="relative w-full aspect-video overflow-hidden bg-slate-950/60 border-b border-white/10">
                                    <img src="{{ asset($catatan->foto) }}" alt="Foto Catatan" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                                    <span class="absolute bottom-3 left-4 text-[10px] bg-amber-500/20 text-amber-300 font-bold px-3 py-1 rounded-full border border-amber-400/40 backdrop-blur-md uppercase shadow-lg">
                                        📷 Lampiran Foto
                                    </span>
                                </div>
                            @endif

                            <div class="p-6 md:p-8 space-y-4 flex-1 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-start gap-3">
                                        <h3 class="font-black text-white text-base tracking-tight leading-snug">{{ $catatan->judul ?? 'Tanpa Judul' }}</h3>
                                        <span class="text-[10px] bg-white/10 px-2.5 py-1 rounded-xl text-slate-300 shrink-0 font-semibold border border-white/10">{{ $catatan->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs text-slate-300 leading-relaxed whitespace-pre-line font-medium bg-white/5 p-4 rounded-2xl border border-white/10">
                                        {{ $catatan->isi_catatan }}
                                    </p>
                                </div>

                                <!-- Tombol Hapus Catatan -->
                                <div class="pt-4 border-t border-white/10 flex justify-end">
                                    <form action="{{ route('catatan.destroy', $catatan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan pribadi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-300 border border-red-400/30 hover:bg-red-500/30 rounded-xl font-bold text-xs transition flex items-center gap-1.5 shadow-lg">
                                            <span>🗑️</span> Hapus Catatan
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <!-- Tampilan Kosong -->
                <div class="bg-slate-900/65 backdrop-blur-2xl rounded-[2.5rem] p-12 text-center space-y-4 border border-white/20 shadow-2xl max-w-lg mx-auto">
                    <div class="w-16 h-16 bg-amber-500/20 text-amber-300 border border-amber-400/30 rounded-3xl flex items-center justify-center mx-auto text-3xl shadow-inner">
                        📒
                    </div>
                    <h4 class="font-bold text-white text-base">Belum ada catatan pribadi.</h4>
                    <p class="text-xs text-slate-300 max-w-sm mx-auto">Mulai buat catatan atau pengingat pertamamu menggunakan form di atas secara privat.</p>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
