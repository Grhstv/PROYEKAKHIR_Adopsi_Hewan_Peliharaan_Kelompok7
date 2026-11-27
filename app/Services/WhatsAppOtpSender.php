<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class WhatsAppOtpSender
{
    public function isConfigured(): bool
    {
        return filled(config('services.whatsapp.phone_number_id'))
            && filled(config('services.whatsapp.access_token'));
    }

    public function send(string $phone, string $code): void
    {
        $phoneNumberId = config('services.whatsapp.phone_number_id');
        $accessToken = config('services.whatsapp.access_token');

        if (! $this->isConfigured()) {
            throw new RuntimeException('WhatsApp Cloud API is not configured.');
        }

        /** @var PendingRequest $request */
        $request = Http::acceptJson()
            ->withToken($accessToken)
            ->timeout(10);

        $request->post(
            'https://graph.facebook.com/'.config('services.whatsapp.graph_version').'/'.$phoneNumberId.'/messages',
            [
                'messaging_product' => 'whatsapp',
                'to' => ltrim($phone, '+'),
                'type' => 'template',
                'template' => [
                    'name' => config('services.whatsapp.otp_template'),
                    'language' => ['code' => config('services.whatsapp.otp_language')],
                    'components' => [[
                        'type' => 'body',
                        'parameters' => [[
                            'type' => 'text',
                            'text' => $code,
                        ]],
                    ]],
                ],
            ],
        )->throw();
    }
}
