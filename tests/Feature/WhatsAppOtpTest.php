<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WhatsAppOtpTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_request_and_verify_whatsapp_login_otp(): void
    {
        $user = User::factory()->create(['phone' => '+6281234567890']);
        $this->get(route('login.otp'))->assertOk()->assertSee('Masukkan nomor WhatsApp');
        $sentCode = null;
        config([
            'services.whatsapp.phone_number_id' => 'phone-number-id',
            'services.whatsapp.access_token' => 'test-access-token',
        ]);
        Http::fake(function (ClientRequest $request) use (&$sentCode) {
            $sentCode = $request->data()['template']['components'][0]['parameters'][0]['text'];

            return Http::response(['messages' => [['id' => 'message-id']]], 200);
        });

        $this->post(route('login.otp.send'), ['phone' => '081234567890'])
            ->assertRedirect()
            ->assertSessionHas('otp_sent', true);

        $this->assertIsString($sentCode);
        Http::assertSent(fn (ClientRequest $request): bool => str_contains($request->url(), '/phone-number-id/messages')
            && $request->data()['to'] === '6281234567890');

        $this->post(route('login.otp.verify'), [
            'phone' => '+6281234567890',
            'otp' => $sentCode,
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($user);
    }

    public function test_unregistered_number_receives_generic_response_without_sending_message(): void
    {
        config([
            'services.whatsapp.phone_number_id' => 'phone-number-id',
            'services.whatsapp.access_token' => 'test-access-token',
        ]);
        Http::fake();

        $this->post(route('login.otp.send'), ['phone' => '081234567890'])
            ->assertSessionHas('otp_sent', true)
            ->assertSessionHas('status', 'Jika nomor terdaftar, kode OTP akan dikirim melalui WhatsApp.');

        Http::assertNothingSent();
    }

    public function test_missing_whatsapp_configuration_is_reported(): void
    {
        User::factory()->create(['phone' => '+6281234567890']);
        config([
            'services.whatsapp.phone_number_id' => null,
            'services.whatsapp.access_token' => null,
        ]);
        Http::fake();

        $this->post(route('login.otp.send'), ['phone' => '081234567890'])
            ->assertSessionHas('error', 'Layanan OTP WhatsApp belum dikonfigurasi.');

        Http::assertNothingSent();
    }

    public function test_five_invalid_codes_invalidate_the_otp_challenge(): void
    {
        User::factory()->create(['phone' => '+6281234567890']);
        config([
            'services.whatsapp.phone_number_id' => 'phone-number-id',
            'services.whatsapp.access_token' => 'test-access-token',
        ]);
        Http::fake();

        $this->post(route('login.otp.send'), ['phone' => '081234567890']);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('login.otp.verify'), [
                'phone' => '081234567890',
                'otp' => '000000',
            ])->assertSessionHasErrors('otp');
        }

        $this->assertGuest();
    }
}
