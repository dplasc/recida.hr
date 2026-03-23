<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8nContactWebhookService
{
    /**
     * Send contact form data to n8n webhook.
     * Never throws; returns structured result for optional inspection.
     *
     * @return array{success: bool, data?: array, error?: string}
     */
    public function send(Contact $contact, ?string $subject = null): array
    {
        $url = config('services.n8n_contact.webhook_url');
        $secret = config('services.n8n_contact.webhook_secret');
        $timeout = (int) config('services.n8n_contact.timeout', 10);

        if (empty($url) || empty($secret)) {
            Log::warning('n8n contact webhook skipped: URL or secret not configured', [
                'contact_id' => $contact->id,
            ]);
            return ['success' => false, 'error' => 'n8n contact webhook not configured'];
        }

        $payload = [
            'contact_id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone ?: null,
            'subject' => $subject ?: null,
            'message' => $contact->message,
            'created_at' => optional($contact->created_at)?->toIso8601String(),
            'source' => 'website_contact_form',
        ];

        try {
            $response = Http::withToken($secret)
                ->acceptJson()
                ->timeout($timeout)
                ->post($url, $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json() ?? [],
                ];
            }

            Log::warning('n8n contact webhook failed', [
                'contact_id' => $contact->id,
                'endpoint' => $url,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => "HTTP {$response->status()}",
            ];
        } catch (\Throwable $e) {
            Log::warning('n8n contact webhook exception', [
                'contact_id' => $contact->id,
                'endpoint' => $url,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
