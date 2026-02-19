<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ViziProvisioner
{
    /**
     * Provision a user on Vizi after successful ReciDa PRO subscription.
     * Does not throw; logs errors and returns structured result.
     *
     * @return array{success: bool, data?: array, error?: string}
     */
    public function provisionUser(User $user): array
    {
        $url = config('services.vizi.url');
        $secret = config('services.vizi.secret');

        if (empty($url) || empty($secret)) {
            Log::warning('Vizi provisioning skipped: URL or secret not configured', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            return ['success' => false, 'error' => 'Vizi not configured'];
        }

        $username = $this->resolveUsername($user);

        $payload = [
            'email' => $user->email,
            'username' => $username,
            'recida_user_id' => (string) $user->id,
        ];

        try {
            $response = Http::withToken($secret)
                ->timeout(15)
                ->post($url, $payload);

            if ($response->successful() || $response->status() === 409) {
                return [
                    'success' => true,
                    'data' => $response->json() ?? [],
                ];
            }

            Log::error('Vizi provisioning failed', [
                'user_id' => $user->id,
                'email' => $user->email,
                'endpoint' => $url,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => "HTTP {$response->status()}",
                'body' => $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error('Vizi provisioning exception', [
                'user_id' => $user->id,
                'email' => $user->email,
                'endpoint' => $url,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Username per locked schema: user.username ?? Str::slug(user.name) ?? ("user-" + user.id).
     */
    private function resolveUsername(User $user): string
    {
        $username = $user->username ?? null;
        if ($username !== null && $username !== '') {
            return $username;
        }

        $slug = Str::slug($user->name ?? '');
        if ($slug !== '') {
            return $slug;
        }

        return 'user-' . $user->id;
    }
}
