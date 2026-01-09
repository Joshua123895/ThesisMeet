<?php

namespace App\Notifications\Channels;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

class ResendChannel
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.resend.com/']);
    }

    public function send($notifiable, Notification $notification)
    {
        $apiKey = env('RESEND_API_KEY');
        if (empty($apiKey)) {
            // Fail silently so app doesn't crash if not configured.
            return;
        }

        if (! method_exists($notification, 'toResend')) {
            return;
        }

        $payload = $notification->toResend($notifiable);

        $headers = [
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ];

        try {
            $this->client->post('emails', [
                'headers' => $headers,
                'json' => $payload,
                'http_errors' => false,
            ]);
        } catch (\Throwable $e) {
            // Log and continue
            logger()->error('ResendChannel error: ' . $e->getMessage());
        }
    }
}
