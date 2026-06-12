<x-guest-layout title="Black Diamond - Verifikasi Email">
    <div class="mb-5 text-sm text-slate-600 text-center leading-relaxed">
        Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengeklik link yang baru saja kami kirimkan. Jika tidak menerimanya, kami akan mengirimkan yang baru.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold text-center">
            Link verifikasi baru telah dikirimkan ke alamat email yang Anda daftarkan.
        </div>
    @endif

    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit"
                class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl shadow-md text-xs transition-all hover:-translate-y-0.5 text-center">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full py-2.5 px-4 text-xs font-bold text-slate-500 hover:text-red-600 transition-colors text-center border border-slate-200 hover:border-red-100 rounded-xl hover:bg-red-50/30">
                Keluar / Logout
            </button>
        </form>
    </div>
</x-guest-layout>
