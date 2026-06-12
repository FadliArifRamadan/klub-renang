<x-guest-layout title="Black Diamond - Login">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Username / Email Address -->
        <div>
            <label for="username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-user mr-1 text-slate-400"></i> Username
            </label>
            <input id="username" type="text" name="username" :value="old('username')" required autofocus
                class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Masukkan username Anda" />
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    <i class="fa-solid fa-lock mr-1 text-slate-400"></i> Password
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Masukkan password Anda" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-slate-350 text-blue-600 shadow-sm focus:ring-blue-500 h-4 w-4">
            <label for="remember_me" class="ms-2.5 text-xs font-semibold text-slate-600 select-none cursor-pointer">
                Ingat saya di perangkat ini
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition-all hover:-translate-y-0.5 text-sm">
                Masuk ke Akun <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </div>
    </form>

    <!-- Footer Links -->
    <div class="mt-6 pt-5 border-t border-slate-100 text-center">
        <p class="text-xs text-slate-500">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline">
                Daftar Sekarang
            </a>
        </p>
    </div>
</x-guest-layout>
