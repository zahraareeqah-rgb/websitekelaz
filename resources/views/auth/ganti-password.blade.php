@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-5"
     x-data="{ showOld: false, showNew: false, showConfirm: false }">
    <div>
        <h2 class="text-lg font-bold text-slate-900">🔒 Ubah Password Akun</h2>
        <p class="text-xs text-slate-500 mt-1">Ganti password sementara dari admin dengan password rahasia kamu sendiri.</p>
    </div>

    @if($errors->any())
        <div class="p-3 bg-red-50 text-red-600 rounded-xl text-xs">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST" class="space-y-4 text-xs">
        @csrf

        <!-- Password Lama -->
        <div>
            <label class="block font-semibold text-slate-700 mb-1">Password Lama</label>
            <div class="relative">
                <input :type="showOld ? 'text' : 'password'" name="current_password" required placeholder="Masukkan password lama (misal: 12345678)" class="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500">
                <button type="button" @click="showOld = !showOld" class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                    <span x-text="showOld ? '👁️' : '👁️‍🗨️'"></span>
                </button>
            </div>
        </div>

        <!-- Password Baru -->
        <div>
            <label class="block font-semibold text-slate-700 mb-1">Password Baru</label>
            <div class="relative">
                <input :type="showNew ? 'text' : 'password'" name="new_password" required placeholder="Minimal 6 karakter" class="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500">
                <button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                    <span x-text="showNew ? '👁️' : '👁️‍🗨️'"></span>
                </button>
            </div>
        </div>

        <!-- Konfirmasi Password Baru -->
        <div>
            <label class="block font-semibold text-slate-700 mb-1">Konfirmasi Password Baru</label>
            <div class="relative">
                <input :type="showConfirm ? 'text' : 'password'" name="new_password_confirmation" required placeholder="Ketik ulang password baru" class="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500">
                <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                    <span x-text="showConfirm ? '👁️' : '👁️‍🗨️'"></span>
                </button>
            </div>
        </div>

        <div class="pt-2 flex justify-end gap-2">
            <a href="{{ route('home') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-semibold hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow transition">Simpan Password</button>
        </div>
    </form>
</div>
@endsection
