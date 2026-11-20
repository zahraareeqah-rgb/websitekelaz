<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Websitera XI RPL 1</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative min-h-screen w-full flex items-center justify-between bg-cover bg-center text-white font-sans p-6 md:p-12 overflow-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');">

    <!-- Overlay Gelap Tipis agar background kelas tetap terlihat hidup -->
    <div class="absolute inset-0 bg-black/40 z-0"></div>

    <!-- Container Utama (Grid Kiri dan Kanan) -->
    <div class="relative z-10 w-full max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center min-h-[85vh]">

        <!-- SISI KIRI: Teks & Informasi Kelas (Melayang Natural) -->
        <div class="lg:col-span-7 space-y-6 text-left">
            <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md border border-white/20 text-emerald-300 px-4 py-1.5 rounded-full text-xs font-semibold shadow-lg">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Portal Resmi • XI RPL 1</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight drop-shadow-md">
                Kelola Kelas Jadi Lebih Mudah.
            </h1>

            <p class="text-slate-200 text-sm sm:text-base leading-relaxed max-w-xl drop-shadow font-medium">
                Sistem informasi terpadu keanggotaan, jadwal pelajaran harian, absensi real-time, dan wawasan interaktif khusus kelas <span class="text-emerald-300 font-bold">Rekayasa Perangkat Lunak 1</span>.
            </p>

            <!-- Statistik Singkat -->
            <div class="grid grid-cols-3 gap-4 max-w-md pt-2">
                <div class="bg-white/10 backdrop-blur-md border border-white/15 p-3.5 rounded-2xl shadow-lg">
                    <span class="block text-xl font-extrabold text-white">40</span>
                    <span class="text-[10px] text-slate-300 uppercase tracking-widest font-semibold">Siswa Aktif</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/15 p-3.5 rounded-2xl shadow-lg">
                    <span class="block text-xl font-extrabold text-emerald-400">Live</span>
                    <span class="text-[10px] text-slate-300 uppercase tracking-widest font-semibold">Jadwal & Absen</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/15 p-3.5 rounded-2xl shadow-lg">
                    <span class="block text-xl font-extrabold text-white">Smart</span>
                    <span class="text-[10px] text-slate-300 uppercase tracking-widest font-semibold">API Dashboard</span>
                </div>
            </div>
        </div>

        <!-- SISI KANAN: Card Login Glassmorphism Melayang (Transparan Kaca) -->
        <div class="lg:col-span-5 w-full max-w-md mx-auto">
            <div class="bg-black/35 backdrop-blur-xl border border-white/20 p-8 rounded-3xl shadow-2xl text-left space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-white tracking-tight">Masuk Akun</h2>
                    <p class="text-slate-300 text-xs mt-1">Masukkan email dan password terdaftar kamu.</p>
                </div>

                <!-- Pesan Error Validasi -->
                @if ($errors->any())
                    <div class="p-3 bg-red-500/20 border border-red-500/30 text-red-200 rounded-2xl text-xs font-semibold backdrop-blur-md">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-slate-300">Email Akademik</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:bg-white/20 transition shadow-inner"
                        >
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-slate-300">Password</label>
                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:bg-white/20 transition shadow-inner"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl transition duration-200 shadow-lg shadow-emerald-500/30 text-xs tracking-wider uppercase mt-2"
                    >
                        Masuk ke Dashboard
                    </button>
                </form>

                <div class="pt-4 border-t border-white/10 text-center">
                    <p class="text-[11px] text-slate-300">
                        Ada kendala akun? Hubungi pengurus kelas XI RPL 1.
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
