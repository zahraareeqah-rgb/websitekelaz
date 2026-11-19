<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Portal 🎓</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk interaksi -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased" x-data="{ logoutModal: false, userMenuOpen: false }">

    <!-- Container Utama Full Layar -->
    <div class="flex flex-col h-screen w-screen overflow-hidden bg-slate-100">

        <!-- TOP NAVBAR -->
        <header class="bg-slate-900 text-white px-8 py-3.5 flex items-center justify-between shadow-md shrink-0 z-30">

            <!-- Logo & Brand (Dropdown Biodata Siswa & Logout) -->
            <div class="relative">
                @php
                    $siswaLogin = auth()->check() ? \App\Models\Siswa::where('email', auth()->user()->email)->first() : null;
                @endphp

                <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-3 focus:outline-none group">
                    @if($siswaLogin && $siswaLogin->foto)
                        <img src="{{ asset($siswaLogin->foto) }}" alt="Foto Profil" class="w-9 h-9 rounded-2xl object-cover border border-slate-700 shadow-md group-hover:scale-105 transition">
                    @else
                        <div class="bg-gradient-to-tr from-blue-600 to-indigo-600 text-white w-9 h-9 rounded-2xl flex items-center justify-center font-bold text-sm shadow-md group-hover:scale-105 transition">
                            CP
                        </div>
                    @endif

                    <div class="text-left">
                        <h2 class="font-bold text-sm leading-tight flex items-center gap-1">
                            {{ $siswaLogin ? $siswaLogin->nama_siswa : (auth()->user()->name ?? 'Class Portal') }} <span class="text-[10px] text-slate-400">▼</span>
                        </h2>
                        <span class="text-[10px] text-blue-400 font-medium">
                            @if($siswaLogin)
                                Absen: {{ $siswaLogin->absen }} | NISN: {{ $siswaLogin->nisn }}
                            @endif
                        </span>
                    </div>
                </button>

                <!-- Dropdown Menu Biodata & Logout -->
                <div x-show="userMenuOpen"
                     @click.outside="userMenuOpen = false"
                     x-transition
                     class="absolute left-0 mt-2 w-64 bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl p-4 z-50 text-xs text-slate-300 space-y-3"
                     style="display: none;"
                     x-cloak>

                    <div class="flex items-center gap-3 pb-3 border-b border-slate-800">
                        @if($siswaLogin && $siswaLogin->foto)
                            <img src="{{ asset($siswaLogin->foto) }}" alt="Foto Profil" class="w-12 h-12 rounded-2xl object-cover border border-slate-700">
                        @else
                            <div class="bg-blue-600 text-white w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-base">
                                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                            </div>
                        @endif
                        <div class="overflow-hidden">
                            <p class="font-bold text-white truncate text-sm">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded-md text-[9px] uppercase font-semibold">
                                {{ auth()->user()->role ?? 'Siswa' }}
                            </span>
                        </div>
                    </div>

                    @if($siswaLogin)
                        <div class="space-y-1 text-[11px] text-slate-400 bg-slate-950/50 p-2.5 rounded-2xl border border-slate-800/60">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Nomor Absen:</span>
                                <span class="font-bold text-slate-200">{{ $siswaLogin->absen ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">NISN:</span>
                                <span class="font-bold text-slate-200">{{ $siswaLogin->nisn ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Kelas:</span>
                                <span class="font-bold text-slate-200">{{ $siswaLogin->kelas ?? '-' }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Tombol Ganti Password -->
                    <a href="{{ route('password.edit') }}" class="w-full text-left px-3 py-2 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                        <span>🔑</span> Ganti Password
                    </a>

                    <!-- Tombol Keluar / Logout -->
                    <button @click="userMenuOpen = false; logoutModal = true" class="w-full text-left px-3 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                        <span>🚪</span> Keluar / Logout
                    </button>
                </div> <!-- END DROPDOWN MENU -->
            </div>

            <!-- Menu Navigasi Horizontal di Tengah -->
            <!-- Menu Navigasi Horizontal di Tengah -->
            <nav class="hidden md:flex items-center gap-1.5 bg-slate-950/50 p-1.5 rounded-2xl border border-slate-800">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl font-medium text-xs {{ request()->routeIs('home') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                    🏠 Home
                </a>
                <a href="{{ route('jadwal.index') }}" class="px-4 py-2 rounded-xl font-medium text-xs {{ request()->routeIs('jadwal.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                    📊 Jadwal
                </a>
                <a href="{{ route('mapel.index') }}" class="px-4 py-2 rounded-xl font-medium text-xs {{ request()->routeIs('mapel.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                    📚 Mapel
                </a>
                <a href="{{ route('tugas.index') }}" class="px-4 py-2 rounded-xl font-medium text-xs {{ request()->routeIs('tugas.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                    📝 Tugas
                </a>
                <a href="{{ route('absensi.index') }}" class="px-4 py-2 rounded-xl font-medium text-xs {{ request()->routeIs('absensi.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                    ✅ Absensi
                </a>

                <!-- TAMBAHKAN MENU CATATAN DI SINI -->
                <a href="{{ route('catatan.index') }}" class="px-4 py-2 rounded-xl font-medium text-xs {{ request()->routeIs('catatan.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                    📒 Catatan Pribadi
                </a>
            </nav>

            <!-- Bagian Kanan Navbar Dikosongkan/Persimpel -->
            <div></div>

        </header>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex overflow-hidden p-3 gap-3">
            <main class="flex-1 overflow-y-auto pr-1">
                @yield('content')
            </main>
        </div>

        <!-- FOOTER GLOBAL -->
        <footer class="bg-white border-t border-slate-200 py-3 px-8 text-center text-xs text-slate-500 flex items-center justify-between shrink-0">
            <p>&copy; 2026 <span class="font-semibold text-slate-700">Websitera Portal</span>. All rights reserved.</p>
            <div class="flex items-center gap-4 text-slate-500">
                <a href="#" class="hover:text-blue-600 transition">Tentang Kami</a>
                <a href="#" class="hover:text-blue-600 transition">Kebijakan Privasi</a>
            </div>
        </footer>

    </div>

    <!-- MODAL KONFIRMASI LOGOUT -->
    <div x-show="logoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
        <div @click.outside="logoutModal = false" class="bg-white rounded-3xl p-6 max-w-sm w-full shadow-2xl text-center space-y-4 border border-slate-100">
            <div class="w-12 h-12 bg-red-100 text-red-500 rounded-2xl flex items-center justify-center mx-auto text-xl">⚠️</div>
            <div>
                <h3 class="font-bold text-slate-900 text-lg">Konfirmasi Keluar</h3>
                <p class="text-slate-500 text-xs mt-1">Yakin akan keluar dari akun Websitera?</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button @click="logoutModal = false" type="button" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition">Batal</button>
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl text-xs transition shadow-md">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
