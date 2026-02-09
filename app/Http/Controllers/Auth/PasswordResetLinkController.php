<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /** 
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
    
        // Dynamically set mail configuration
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
    
        // Attempt to send the reset link
        $status = Password::sendResetLink($request->only('email'));
    
        // Handle the result
        if ($status == Password::RESET_LINK_SENT) {
            Session::flash('success', get_phrase('A confirmation email has been sent. Please check your inbox.'));
            return redirect(route('login'))->with('status', __($status));
        } else {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        }
    }
    
    
}
