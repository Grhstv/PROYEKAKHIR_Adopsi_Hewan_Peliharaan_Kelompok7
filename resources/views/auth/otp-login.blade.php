<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
        <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    @if (session('otp_sent') || old('otp'))
        <form method="POST" action="{{ route('login.otp.verify') }}" class="space-y-4">
            @csrf
            <div>
                <x-input-label for="phone" value="Nomor WhatsApp" />
                <x-text-input id="phone" class="mt-1 block w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="otp" value="Kode OTP 6 digit" />
                <x-text-input id="otp" class="mt-1 block w-full" type="text" name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autocomplete="one-time-code" />
                <x-input-error :messages="$errors->get('otp')" class="mt-2" />
            </div>
            <x-primary-button>Verifikasi dan masuk</x-primary-button>
        </form>
        <form method="POST" action="{{ route('login.otp.send') }}" class="mt-4">
            @csrf
            <input type="hidden" name="phone" value="{{ old('phone') }}">
            <button type="submit" class="text-sm text-indigo-600 underline">Kirim ulang OTP</button>
        </form>
    @else
        <p class="mb-4 text-sm text-gray-600">Masukkan nomor WhatsApp yang terdaftar untuk menerima kode OTP.</p>
        <form method="POST" action="{{ route('login.otp.send') }}" class="space-y-4">
            @csrf
            <div>
                <x-input-label for="phone" value="Nomor WhatsApp" />
                <x-text-input id="phone" class="mt-1 block w-full" type="tel" name="phone" :value="old('phone')" required autofocus autocomplete="tel" placeholder="08xxxxxxxxxx" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <x-primary-button>Kirim OTP WhatsApp</x-primary-button>
        </form>
    @endif

    <p class="mt-5 text-center text-sm text-gray-600">
        <a href="{{ route('login') }}" class="text-indigo-600 underline">Kembali ke login kata sandi</a>
    </p>
</x-guest-layout>
