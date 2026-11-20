
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Class Portal 🎓</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        :root {
            --navy: #071a22;
            --navy-light: #102b34;
            --teal: #5bd6c2;
            --teal-dark: #36b9a6;
            --text-light: #e8f3f1;
            --muted: #a4bfbb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--navy);
            color: var(--text-light);
        }

        .portal-shell {
            background: var(--navy);
        }

        /* NAVBAR */

        .portal-header {
            background: rgba(5, 22, 30, 0.96);
            border-bottom: 1px solid rgba(255,255,255,0.09);
            backdrop-filter: blur(18px);
            padding: 16px 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .portal-header nav {
            background: rgba(255,255,255,0.055);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 50px;
            padding: 5px;
        }

        .portal-header nav a {
            border-radius: 50px;
            padding: 10px 16px;
            transition: 0.25s ease;
        }

        .portal-header nav a.bg-blue-600 {
            background: var(--teal) !important;
            color: #08252a !important;
            box-shadow: 0 5px 18px rgba(91,214,194,0.2);
        }

        .portal-header nav a:not(.bg-blue-600) {
            color: #c7d9d6;
        }

        .portal-header nav a:not(.bg-blue-600):hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        /* MAIN BACKGROUND */

        .portal-main-wrap {
            background:
                radial-gradient(
                    ellipse at 15% 0%,
                    rgba(42,130,126,0.16),
                    transparent 45%
                ),
                var(--navy);
            padding: 22px;
        }

        .portal-main {
            scrollbar-width: thin;
            scrollbar-color: #31565a transparent;
        }

        /* FOOTER */

        .portal-footer {
            background: #06151c;
            border-top: 1px solid rgba(255,255,255,0.09);
            color: #91a9a9;
        }

        .portal-footer .text-slate-700 {
            color: #dce9e8;
        }

        .portal-footer a:hover {
            color: var(--teal);
        }

        /* PROFILE DROPDOWN */

        .portal-header [x-show="userMenuOpen"] {
            background: #102b34 !important;
            border: 1px solid rgba(255,255,255,0.12) !important;
            box-shadow: 0 20px 50px rgba(0,0,0,0.4) !important;
        }

        /* LOGOUT MODAL */

        .portal-modal {
            background: rgba(0,0,0,0.65);
            backdrop-filter: blur(8px);
        }

        /* GENERAL TRANSITIONS */

        a, button {
            transition: all 0.25s ease;
        }

        /* RESPONSIVE */

        @media (max-width: 767px) {

            .portal-header {
                padding: 12px 16px;
            }

            .portal-main-wrap {
                padding: 12px;
            }

            .portal-footer {
                padding: 12px 16px;
                gap: 8px;
                flex-wrap: wrap;
            }

        }

    </style>

</head>

<body
    class="portal-body text-slate-800 font-sans antialiased"
    x-data="{ logoutModal: false, userMenuOpen: false }"
>

    <div class="portal-shell flex flex-col h-screen w-screen overflow-hidden">

        <!-- ================= NAVBAR ================= -->

        <header class="portal-header text-white flex items-center justify-between shrink-0 z-30">

            <!-- LOGO / PROFILE -->

            <div class="relative">

                @php
                    $siswaLogin = auth()->check()
                        ? \App\Models\Siswa::where('email', auth()->user()->email)->first()
                        : null;
                @endphp

                <button
                    @click="userMenuOpen = !userMenuOpen"
                    class="flex items-center gap-3 focus:outline-none group"
                >

                    @if($siswaLogin && $siswaLogin->foto)

                        <img
                            src="{{ asset($siswaLogin->foto) }}"
                            alt="Foto Profil"
                            class="w-10 h-10 rounded-full object-cover border border-white/20 shadow-md"
                        >

                    @else

                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-teal-400 to-emerald-500 text-slate-950 flex items-center justify-center font-bold text-sm">
                            CP
                        </div>

                    @endif

                    <div class="text-left">

                        <h2 class="font-bold text-sm leading-tight flex items-center gap-1">

                            {{ $siswaLogin ? $siswaLogin->nama_siswa : (auth()->user()->name ?? 'Class Portal') }}

                            <span class="text-xs text-slate-400">▼</span>

                        </h2>

                        <span class="text-[10px] text-teal-300 font-medium">

                            @if($siswaLogin)
                                Absen: {{ $siswaLogin->absen }} | NISN: {{ $siswaLogin->nisn }}
                            @endif

                        </span>

                    </div>

                </button>

                <!-- DROPDOWN PROFILE -->

                <div
                    x-show="userMenuOpen"
                    @click.outside="userMenuOpen = false"
                    x-transition
                    x-cloak
                    style="display: none;"
                    class="absolute left-0 mt-3 w-64 rounded-3xl shadow-2xl p-4 z-50 text-xs text-slate-300 space-y-3"
                >

                    <div class="flex items-center gap-3 pb-3 border-b border-slate-700">

                        @if($siswaLogin && $siswaLogin->foto)

                            <img
                                src="{{ asset($siswaLogin->foto) }}"
                                class="w-12 h-12 rounded-full object-cover"
                                alt="Foto Profil"
                            >

                        @else

                            <div class="w-12 h-12 rounded-full bg-teal-400 text-slate-950 flex items-center justify-center font-bold text-base">

                                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}

                            </div>

                        @endif

                        <div class="overflow-hidden">

                            <p class="font-bold text-white text-sm truncate">
                                {{ auth()->user()->name ?? 'User' }}
                            </p>

                            <p class="text-[10px] text-slate-400 truncate">
                                {{ auth()->user()->email ?? '' }}
                            </p>

                            <span class="inline-block mt-1 px-2 py-0.5 bg-teal-500/20 text-teal-300 rounded-md text-[9px] uppercase font-semibold">
                                {{ auth()->user()->role ?? 'Siswa' }}
                            </span>

                        </div>

                    </div>

                    @if($siswaLogin)

                        <div class="space-y-2 text-[11px] text-slate-400 bg-black/20 p-3 rounded-2xl">

                            <div class="flex justify-between">
                                <span>Nomor Absen:</span>
                                <span class="font-bold text-white">{{ $siswaLogin->absen ?? '-' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span>NISN:</span>
                                <span class="font-bold text-white">{{ $siswaLogin->nisn ?? '-' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span>Kelas:</span>
                                <span class="font-bold text-white">{{ $siswaLogin->kelas ?? '-' }}</span>
                            </div>

                        </div>

                    @endif

                    <!-- GANTI PASSWORD -->

                    <a
                        href="{{ route('password.edit') }}"
                        class="w-full px-3 py-2 bg-teal-500/10 hover:bg-teal-500/20 text-teal-300 rounded-xl font-semibold flex items-center justify-center gap-2"
                    >
                        🔑 Ganti Password
                    </a>

                    <!-- LOGOUT -->

                    <button
                        @click="userMenuOpen = false; logoutModal = true"
                        class="w-full px-3 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-xl font-semibold flex items-center justify-center gap-2"
                    >
                        🚪 Keluar / Logout
                    </button>

                </div>

            </div>

            <!-- NAVIGATION -->

            <nav class="hidden md:flex items-center gap-1.5">

                <a
                    href="{{ route('home') }}"
                    class="px-4 py-2 font-medium text-xs {{ request()->routeIs('home') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300' }}"
                >
                    🏠 Home
                </a>

                <a
                    href="{{ route('jadwal.index') }}"
                    class="px-4 py-2 font-medium text-xs {{ request()->routeIs('jadwal.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300' }}"
                >
                    📊 Jadwal
                </a>

                <a
                    href="{{ route('mapel.index') }}"
                    class="px-4 py-2 font-medium text-xs {{ request()->routeIs('mapel.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300' }}"
                >
                    📚 Mapel
                </a>

                <a
                    href="{{ route('tugas.index') }}"
                    class="px-4 py-2 font-medium text-xs {{ request()->routeIs('tugas.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300' }}"
                >
                    📝 Tugas
                </a>

                <a
                    href="{{ route('absensi.index') }}"
                    class="px-4 py-2 font-medium text-xs {{ request()->routeIs('absensi.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300' }}"
                >
                    ✅ Absensi
                </a>

                <a
                    href="{{ route('catatan.index') }}"
                    class="px-4 py-2 font-medium text-xs {{ request()->routeIs('catatan.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-300' }}"
                >
                    📒 Catatan Pribadi
                </a>

            </nav>

            <div></div>

        </header>

        <!-- ================= MAIN CONTENT ================= -->

        <div class="portal-main-wrap flex-1 flex overflow-hidden gap-3">

            <main class="portal-main flex-1 overflow-y-auto pr-1">

                @yield('content')

            </main>

        </div>

        <!-- ================= FOOTER ================= -->

        <footer class="portal-footer py-3 px-8 text-center text-xs flex items-center justify-between shrink-0">

            <p>
                &copy; 2026
                <span class="font-semibold">Websitera Portal</span>.
                All rights reserved.
            </p>

            <div class="flex items-center gap-4">

                <a href="#" class="hover:text-teal-300">
                    Tentang Kami
                </a>

                <a href="#" class="hover:text-teal-300">
                    Kebijakan Privasi
                </a>

            </div>

        </footer>

    </div>

    <!-- ================= LOGOUT MODAL ================= -->

    <div
        x-show="logoutModal"
        class="portal-modal fixed inset-0 z-50 flex items-center justify-center"
        x-cloak
    >

        <div
            @click.outside="logoutModal = false"
            class="bg-white rounded-3xl p-6 max-w-sm w-full shadow-2xl text-center space-y-4"
        >

            <div class="w-12 h-12 bg-red-100 text-red-500 rounded-2xl flex items-center justify-center mx-auto text-xl">
                ⚠️
            </div>

            <div>

                <h3 class="font-bold text-slate-900 text-lg">
                    Konfirmasi Keluar
                </h3>

                <p class="text-slate-500 text-xs mt-1">
                    Yakin akan keluar dari akun Websitera?
                </p>

            </div>

            <div class="flex gap-3 pt-2">

                <button
                    @click="logoutModal = false"
                    type="button"
                    class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs"
                >
                    Batal
                </button>

                <form action="{{ route('logout') }}" method="POST" class="flex-1">

                    @csrf

                    <button
                        type="submit"
                        class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl text-xs shadow-md"
                    >
                        Ya, Keluar
                    </button>

                </form>

            </div>

        </div>

    </div>

</body>
</html>
