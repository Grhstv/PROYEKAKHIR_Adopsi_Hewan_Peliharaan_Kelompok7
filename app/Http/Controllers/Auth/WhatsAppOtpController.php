<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WhatsAppOtpSender;
use App\Support\PhoneNumber;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use RuntimeException;

class WhatsAppOtpController extends Controller
{
    private const OTP_TTL_MINUTES = 5;

    public function create(): View
    {
        return view('auth.otp-login');
    }

    public function send(Request $request, WhatsAppOtpSender $sender): RedirectResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'regex:/^[0-9+\s().-]{8,24}$/'],
        ]);
        $phone = PhoneNumber::normalize($data['phone']);

        if (! $sender->isConfigured()) {
            return back()->withInput()->with('error', 'Layanan OTP WhatsApp belum dikonfigurasi.');
        }

        $user = User::where('phone', $phone)->first();

        if ($user === null) {
            return back()
                ->with('otp_sent', true)
                ->with('status', 'Jika nomor terdaftar, kode OTP akan dikirim melalui WhatsApp.');
        }

        $code = (string) random_int(100000, 999999);

        try {
            $sender->send($phone, $code);
        } catch (RuntimeException $exception) {
            report($exception);

            return back()->withInput()->with('error', 'Layanan OTP WhatsApp belum dikonfigurasi.');
        } catch (ConnectionException|RequestException $exception) {
            report($exception);

            return back()->withInput()->with('error', 'WhatsApp gagal mengirim OTP. Periksa konfigurasi dan coba lagi.');
        }

        Cache::put($this->cacheKey($phone), [
            'hash' => Hash::make($code),
            'attempts' => 0,
        ], now()->addMinutes(self::OTP_TTL_MINUTES));

        return back()
            ->with('otp_sent', true)
            ->with('status', 'Jika nomor terdaftar, kode OTP akan dikirim melalui WhatsApp.');
    }

    public function verify(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'regex:/^[0-9+\s().-]{8,24}$/'],
            'otp' => ['required', 'digits:6'],
        ]);

        $phone = PhoneNumber::normalize($data['phone']);
        $cacheKey = $this->cacheKey($phone);
        $challenge = Cache::get($cacheKey);

        if (! is_array($challenge) || ! isset($challenge['hash'], $challenge['attempts'])) {
            return back()->withInput()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        if (! Hash::check($data['otp'], $challenge['hash'])) {
            $challenge['attempts']++;

            if ($challenge['attempts'] >= 5) {
                Cache::forget($cacheKey);
            } else {
                Cache::put($cacheKey, $challenge, now()->addMinutes(self::OTP_TTL_MINUTES));
            }

            return back()->withInput()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        $user = User::where('phone', $phone)->first();
        Cache::forget($cacheKey);

        if ($user === null) {
            return back()->withInput()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    private function cacheKey(string $phone): string
    {
        return 'login-otp:'.hash('sha256', $phone);
    }
}
