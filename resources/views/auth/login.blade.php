<x-guest-layout title="Black Diamond - Login">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Username / Email Address -->
        <div>
            <label for="username" class="block text-xs font-black text-[#101828] uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-user mr-1 text-[#101828]"></i> Username
            </label>
            <input id="username" type="text" name="username" :value="old('username')" required autofocus
                class="block w-full bg-[#101828] border-[#101828] text-white placeholder-slate-400 focus:border-[#101828] focus:ring-2 focus:ring-[#101828] rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Masukkan username Anda" />
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-xs font-black text-[#101828] uppercase tracking-wider">
                    <i class="fa-solid fa-lock mr-1 text-[#101828]"></i> Password
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-black text-[#101828] hover:underline" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <div x-data="{ show: false }" class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                    class="block w-full bg-[#101828] border-[#101828] text-white placeholder-slate-400 focus:border-[#101828] focus:ring-2 focus:ring-[#101828] rounded-xl px-4 py-2.5 pr-10 shadow-sm text-sm transition-colors"
                    placeholder="Masukkan password Anda" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white transition">
                    <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-[#101828] bg-[#101828] text-[#101828] shadow-sm focus:ring-[#101828] h-4 w-4">
            <label for="remember_me" class="ms-2.5 text-xs font-extrabold text-[#101828] select-none cursor-pointer">
                Ingat saya di perangkat ini
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 bg-[#101828] hover:bg-black text-[#D3AF37] font-black rounded-xl shadow-xl shadow-black/30 hover:shadow-black/50 transition-all hover:-translate-y-0.5 text-sm cursor-pointer border border-[#F5E6A3]/30">
                Masuk ke Akun <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </div>
    </form>

    <!-- Footer Links -->
    <div class="mt-6 pt-5 border-t border-[#101828]/20 text-center">
        <p class="text-xs text-[#101828]/90 font-bold">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-black text-[#101828] underline hover:text-black">
                Daftar Sekarang
            </a>
        </p>
    </div>
</x-guest-layout>
