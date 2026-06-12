<x-guest-layout title="Black Diamond - Atur Ulang Password">
    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-envelope mr-1 text-slate-400"></i> Alamat Email
            </label>
            <input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username"
                class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Masukkan email terdaftar Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-lock mr-1 text-slate-400"></i> Password Baru
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Buat password baru minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-shield-check mr-1 text-slate-400"></i> Konfirmasi Password Baru
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Ketik ulang password baru Anda" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 text-sm">
                Atur Ulang Password <i class="fa-solid fa-key text-xs"></i>
            </button>
        </div>
    </form>
</x-guest-layout>
