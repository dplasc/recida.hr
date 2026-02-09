<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if (auth()->check() && $request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        config([
            'mail.mailers.smtp.transport'  => get_settings('smtp_protocol'),
            'mail.mailers.smtp.host'       => get_settings('smtp_host'),
            'mail.mailers.smtp.port'       => get_settings('smtp_port'),
            'mail.mailers.smtp.encryption' => get_settings('smtp_crypto'),
            'mail.mailers.smtp.username'   => get_settings('smtp_username'),
            'mail.mailers.smtp.password'   => get_settings('smtp_password'),
            'mail.from.address'            => get_settings('smtp_username'),
            'mail.from.name'               => get_settings('system_title'),
        ]);
        
        $request->user()->sendEmailVerificationNotification();
        Session::flash('success', get_phrase('A Verification Link Sent your Email . Please Check!'));
        return back()->with('status', 'verification-link-sent');
    }
}
