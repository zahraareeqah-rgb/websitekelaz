<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Websitera</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative min-h-screen flex flex-col justify-between bg-cover bg-center text-white font-sans overflow-y-auto" style="background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=2000&auto=format&fit=crop');">

    <!-- Overlay Gelap Tipis agar teks terbaca jelas -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] z-0"></div>

    <!-- Container Utama -->
    <div class="relative z-10 flex flex-col min-h-screen justify-between p-6">

        <!-- Navbar Mengambang (Ringkas) -->
        <!-- Navbar Mengambang (Tanpa tombol Login dobel) -->
        <header class="flex justify-center">
            <nav class="bg-white/90 backdrop-blur-md px-6 py-2.5 rounded-full shadow-lg flex items-center space-x-6 text-slate-800 text-sm font-medium">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-amber-500 rounded-full inline-block"></span>
                    <span class="font-bold text-slate-900">Websitera</span>
                </div>
                <span class="text-xs bg-slate-100 text-slate-700 px-3 py-1 rounded-full font-semibold border border-slate-200">
                    👥 Member: 40
                </span>
                <a href="#" class="hover:text-indigo-600 transition">Kontak</a>
            </nav>
        </header>

        <!-- Bagian Konten Tengah (Hero & Form Login) -->
        <main class="flex flex-col items-center justify-center my-8 text-center px-4">

            <!-- Badge kecil di atas judul -->
            <div class="inline-flex items-center space-x-2 bg-white/90 backdrop-blur-md text-slate-800 px-4 py-1.5 rounded-full text-xs font-semibold shadow-md mb-4">
                <span>✨ Portal Jadwal & Kelas Pintar</span>
            </div>

            <!-- Judul Utama -->
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight mb-2 drop-shadow-md">
                Kelola Jadwal dengan Mudah.
            </h1>
            <p class="text-slate-100 text-xs md:text-sm max-w-md mb-6 drop-shadow">
                Sistem manajemen jadwal harian dan aktivitas kelas yang dirancang cepat dan efisien.
            </p>

            <!-- Card Form Login yang Lebih Proporsional -->
            <div class="bg-white/95 backdrop-blur-md p-6 md:p-8 rounded-3xl shadow-2xl w-full max-w-sm text-slate-800 text-left">
                <h2 class="text-lg font-bold mb-1 text-slate-900">Masuk ke Akun</h2>
                <p class="text-slate-500 text-xs mb-4">Masukkan email dan password kamu di bawah ini.</p>

                <!-- Pesan Error Validasi -->
                @if ($errors->any())
                    <div class="mb-3 p-2.5 bg-red-100 text-red-600 rounded-xl text-xs font-medium">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('login.process') }}" method="POST" class="space-y-3">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2.5 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 transition shadow-md text-sm mt-1"
                    >
                        Masuk Sekarang
                    </button>
                </form>
            </div>

        </main>

        <!-- Bagian Bawah Kosong untuk Slicing Layout Nanti -->
        <div></div>

    </div>

</body>
</html>
