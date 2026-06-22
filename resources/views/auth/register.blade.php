<x-guest-layout title="Black Diamond - Register">
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-address-card mr-1 text-slate-400"></i> Nama Lengkap
            </label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Masukkan nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Username -->
        <div>
            <label for="username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-user mr-1 text-slate-400"></i> Username
            </label>
            <input id="username" type="text" name="username" :value="old('username')" required
                class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Buat username akun Anda" />
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <!-- Phone Number -->
        <div>
            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-phone mr-1 text-slate-400"></i> Nomor WhatsApp / HP
            </label>
            <input id="phone" type="text" name="phone" :value="old('phone')" required
                class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors"
                placeholder="Contoh: 081234567890" />
            <x-input-error :messages="$errors->get('phone')" class="mt-1" />
        </div>

        <!-- Role Select -->
        <div>
            <label for="role" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-users-gear mr-1 text-slate-400"></i> Mendaftar Sebagai
            </label>
            <select id="role" name="role" required
                class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 shadow-sm text-sm transition-colors bg-white">
                <option value="parent">Orang Tua (Untuk Mendaftarkan Anak)</option>
                <option value="general">Umum (Untuk Mendaftarkan Diri Sendiri)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-lock mr-1 text-slate-400"></i> Password
            </label>
            <div x-data="{ show: false }" class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                    class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 pr-10 shadow-sm text-sm transition-colors"
                    placeholder="Buat password minimal 8 karakter" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition">
                    <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                <i class="fa-solid fa-shield-check mr-1 text-slate-400"></i> Konfirmasi Password
            </label>
            <div x-data="{ show: false }" class="relative">
                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                    class="block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2.5 pr-10 shadow-sm text-sm transition-colors"
                    placeholder="Ketik ulang password Anda" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition">
                    <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition-all hover:-translate-y-0.5 text-sm">
                Daftar Akun Baru <i class="fa-solid fa-user-plus text-xs"></i>
            </button>
        </div>
    </form>

    <!-- Footer Links -->
    <div class="mt-6 pt-5 border-t border-slate-100 text-center">
        <p class="text-xs text-slate-500">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline">
                Masuk Disini
            </a>
        </p>
    </div>
</x-guest-layout>
