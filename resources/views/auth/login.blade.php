<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Class Portal XI RPL 1</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN untuk interaksi Modal Pop-up -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="relative min-h-screen w-full flex items-center justify-between bg-cover bg-center text-white font-sans p-6 md:p-12 overflow-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}');" x-data="{ qrModal: false }">

    <!-- Overlay Gelap Tipis agar background kelas tetap terlihat hidup -->
    <div class="absolute inset-0 bg-black/40 z-0"></div>

    <!-- Container Utama (Grid Kiri dan Kanan) -->
    <div class="relative z-10 w-full max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center min-h-[85vh]">

        <!-- SISI KIRI: Teks & Informasi Kelas (Melayang Natural) -->
        <div class="lg:col-span-7 space-y-6 text-left">
            <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md border border-white/20 text-emerald-300 px-4 py-1.5 rounded-full text-xs font-semibold shadow-lg">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Portal • XI RPL 1</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight drop-shadow-md">
                Website XI RPL 1 .
            </h1>

            <p class="text-slate-200 text-sm sm:text-base leading-relaxed max-w-xl drop-shadow font-medium">
                Sistem informasi terpadu keanggotaan, jadwal pelajaran harian, absensi real-time, dan informasi khusus kelas <span class="text-emerald-300 font-bold">Rekayasa Perangkat Lunak 1</span>.
            </p>

            <!-- Statistik Singkat -->
            <div class="grid grid-cols-3 gap-4 max-w-md pt-2">
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

                <!-- Tombol Kendala Akun / Hubungi Admin -->
                <div class="pt-4 border-t border-white/10 text-center">
                    <button @click="qrModal = true" class="text-[11px] text-slate-300 hover:text-emerald-300 transition font-medium cursor-pointer">
                        Ada kendala? <span class="text-emerald-400 font-bold underline">Hubungi admin website</span>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= MODAL POP-UP SCAN QR CODE WHATSAPP ================= -->
    <div x-show="qrModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md"
         style="display: none;">
        
        <div @click.away="qrModal = false" class="bg-slate-900 border border-emerald-500/40 w-full max-w-sm rounded-[2.5rem] p-6 md:p-8 shadow-2xl relative space-y-5 text-white text-center overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex justify-between items-center">
                <span class="text-[10px] bg-emerald-500/20 text-emerald-300 font-extrabold px-3 py-1 rounded-full border border-emerald-400/30 uppercase tracking-widest">
                    📱 Bantuan Admin
                </span>
                <button @click="qrModal = false" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-slate-300 font-bold transition">
                    ✕
                </button>
            </div>

            <div class="space-y-2">
                <h3 class="text-lg font-black text-white">Scan QR WhatsApp</h3>
                <p class="text-xs text-slate-300">Arahkan kamera HP kamu ke QR Code di bawah untuk terhubung langsung ke Admin / Pengurus Kelas[cite: 11].</p>
            </div>

            <!-- QR Code Otomatis Online (Langsung Bisa Discan) -->
            <div class="bg-white p-3 rounded-3xl shadow-inner inline-block mx-auto border-4 border-emerald-500/30">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=https://wa.me/6289654034447" alt="QR Code WhatsApp Admin" class="w-48 h-48 object-contain mx-auto rounded-xl">
            </div>

            <div class="space-y-1">
                <p class="text-[11px] text-slate-400">Atau hubungi nomor:</p>
                <a href="https://wa.me/6289654034447" target="_blank" class="text-emerald-400 font-mono font-bold text-sm hover:underline block">
                    0896-5403-4447
                </a>
            </div>

            <div>
                <button @click="qrModal = false" class="w-full py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl text-xs uppercase tracking-wider shadow-lg transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</body>
</html>