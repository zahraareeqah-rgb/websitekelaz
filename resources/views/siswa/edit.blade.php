@extends('layouts.app')

@section('content')
<!-- Container Utama Fullscreen dengan Background Papan Tulis Kelas -->
<div class="relative min-h-screen -m-6 p-6 md:p-12 bg-cover bg-center bg-fixed text-white font-sans flex flex-col justify-between overflow-x-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');">

    <!-- Overlay Gelap Tipis & Natural -->
    <div class="absolute inset-0 bg-slate-950/45 backdrop-blur-[1px] z-0"></div>

    <!-- WRAPPER UTAMA -->
    <div class="relative z-10 w-full max-w-xl mx-auto space-y-8 pt-4 pb-16">

        <!-- CARD FORM EDIT SISWA -->
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] p-6 md:p-8 border border-white/20 shadow-2xl space-y-6 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Header Form -->
            <div class="space-y-1 border-b border-white/10 pb-5 relative z-10">
                <span class="text-[10px] bg-emerald-500/20 text-emerald-300 font-extrabold px-3 py-1 rounded-full border border-emerald-400/30 uppercase tracking-widest inline-block mb-2">
                    ✏️ Manajemen Siswa
                </span>
                <h1 class="text-xl md:text-2xl font-black text-white tracking-tight">Edit Data Siswa</h1>
                <p class="text-xs text-slate-300">Perbarui biodata, NISN, alamat, jenis kelamin, email, atau kelola foto profil siswa.</p>
            </div>

            <!-- Tampilkan Error Validasi Jika Ada -->
            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-400/30 text-red-200 px-4 py-3 rounded-2xl text-xs space-y-1 relative z-10">
                    <p class="font-bold">Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Update Siswa -->
            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 relative z-10">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required
                           class="w-full bg-white/5 border border-white/15 rounded-2xl px-4 py-3 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-emerald-400 transition">
                </div>

                <!-- NISN -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" required
                           class="w-full bg-white/5 border border-white/15 rounded-2xl px-4 py-3 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-emerald-400 transition">
                </div>

                <!-- Alamat -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $siswa->alamat) }}" placeholder="Contoh: Jl. Merdeka No. 10"
                           class="w-full bg-white/5 border border-white/15 rounded-2xl px-4 py-3 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-emerald-400 transition">
                </div>

                <!-- Jenis Kelamin -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required
                            class="w-full bg-slate-900 border border-white/15 rounded-2xl px-4 py-3 text-xs text-white focus:outline-none focus:border-emerald-400 transition">
                        <option value="" class="bg-slate-900">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" class="bg-slate-900" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" class="bg-slate-900" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Email (Untuk Login)</label>
                    <input type="email" name="email" value="{{ old('email', $siswa->email) }}" required
                           class="w-full bg-white/5 border border-white/15 rounded-2xl px-4 py-3 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-emerald-400 transition">
                </div>

                <!-- Foto Profil Saat Ini & Opsi Hapus -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Foto Profil Saat Ini</label>

                    @if(isset($siswa->foto) && $siswa->foto)
                        <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10">
                            <img src="{{ asset($siswa->foto) }}" alt="Foto Siswa" class="w-14 h-14 rounded-2xl object-cover border-2 border-emerald-500/40 shadow-md shrink-0">
                            <div class="space-y-2 flex-1">
                                <p class="text-[11px] text-slate-300">Unggah foto baru di bawah jika ingin mengganti, atau centang opsi di bawah untuk menghapus.</p>

                                <!-- Checkbox Hapus Foto -->
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="hapus_foto" value="1" class="rounded bg-white/10 border-white/20 text-red-500 focus:ring-0">
                                    <span class="text-[11px] font-bold text-red-400">kosongkan foto</span>
                                </label>
                            </div>
                        </div>
                    @else
                        <div class="bg-white/5 p-3 rounded-2xl border border-white/10 text-xs text-slate-400 italic">
                            Siswa ini belum memiliki foto profil.
                        </div>
                    @endif
                </div>

                <!-- Input Upload Foto Baru -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Ganti Foto Baru (Opsional)</label>
                    <input type="file" name="foto" accept="image/*"
                           class="w-full bg-white/5 border border-white/15 rounded-2xl px-4 py-2.5 text-xs text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30 transition">
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                    <a href="{{ route('home') }}" class="px-5 py-3 bg-white/10 hover:bg-white/20 text-slate-200 rounded-2xl text-xs font-bold transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl text-xs shadow-xl transition uppercase tracking-wider">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
