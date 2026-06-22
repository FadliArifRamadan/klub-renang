<x-guest-layout title="Black Diamond - Konfirmasi Password">
    <div class="mb-5 text-sm text-slate-600 text-center leading-relaxed">
        Ini adalah area aman aplikasi. Silakan konfirmasi password Anda terlebih dahulu sebelum melanjutkan.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-lock mr-1 text-slate-400"></i> Password
            </label>
            <div x-data="{ show: false }" class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                    class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 pr-10 shadow-sm text-sm transition-colors"
                    placeholder="Masukkan password konfirmasi Anda" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition">
                    <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 text-sm">
                Konfirmasi Password <i class="fa-solid fa-shield-check text-xs"></i>
            </button>
        </div>
    </form>
</x-guest-layout>
