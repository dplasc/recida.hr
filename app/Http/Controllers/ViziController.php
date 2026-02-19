<?php

namespace App\Http\Controllers;

use App\Services\ViziProvisioner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ViziController extends Controller
{
    /**
     * Activate Vizi account for PRO user. Idempotent: if already linked, returns success without re-provisioning.
     */
    public function activate(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! has_pro_subscription($user->id)) {
            return response()->json(['ok' => false, 'error' => 'not_pro'], 403);
        }

        if ($user->vizi_linked_at) {
            return response()->json([
                'ok' => true,
                'action_link' => $user->vizi_last_action_link ?? 'https://www.vizi.hr',
            ]);
        }

        $result = (new ViziProvisioner())->provisionUser($user);

        if (! $result['success']) {
            return response()->json([
                'ok' => false,
                'error' => $result['error'] ?? 'Provisioning failed',
            ], 500);
        }

        $data = $result['data'] ?? [];
        $actionLink = $data['action_link'] ?? null;
        $viziUserId = $data['vizi_user_id'] ?? null;

        $user->update([
            'vizi_user_id' => $viziUserId,
            'vizi_linked_at' => now(),
            'vizi_last_action_link' => $actionLink,
        ]);

        return response()->json([
            'ok' => true,
            'action_link' => $actionLink ?? 'https://www.vizi.hr',
        ]);
    }
}
