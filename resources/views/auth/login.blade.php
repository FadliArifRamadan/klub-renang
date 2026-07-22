<x-guest-layout title="Black Diamond - Login">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Username / Email Address -->
        <div>
            <label for="username" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-user mr-1 text-[#D3AF37]"></i> Username
            </label>
            <input id="username" type="text" name="username" :value="old('username')" required autofocus
                class="block w-full bg-[#0B0F17] border-slate-700 text-white placeholder-slate-500 focus:border-[#D3AF37] focus:ring-1 focus:ring-[#D3AF37] rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Masukkan username Anda" />
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                    <i class="fa-solid fa-lock mr-1 text-[#D3AF37]"></i> Password
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-[#D3AF37] hover:text-[#B89426] hover:underline" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <div x-data="{ show: false }" class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                    class="block w-full bg-[#0B0F17] border-slate-700 text-white placeholder-slate-500 focus:border-[#D3AF37] focus:ring-1 focus:ring-[#D3AF37] rounded-xl px-4 py-2.5 pr-10 shadow-sm text-sm transition-colors"
                    placeholder="Masukkan password Anda" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-200 transition">
                    <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-slate-700 bg-[#0B0F17] text-[#D3AF37] shadow-sm focus:ring-[#D3AF37] h-4 w-4">
            <label for="remember_me" class="ms-2.5 text-xs font-semibold text-slate-300 select-none cursor-pointer">
                Ingat saya di perangkat ini
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-extrabold rounded-xl shadow-lg shadow-[#D3AF37]/20 hover:shadow-[#D3AF37]/30 transition-all hover:-translate-y-0.5 text-sm cursor-pointer">
                Masuk ke Akun <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </div>
    </form>

    <!-- Footer Links -->
    <div class="mt-6 pt-5 border-t border-slate-800 text-center">
        <p class="text-xs text-slate-400">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-bold text-[#D3AF37] hover:text-[#B89426] hover:underline">
                Daftar Sekarang
            </a>
        </p>
    </div>
</x-guest-layout>
