<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 2, 
            'type' => 'customer', 
            'status' => 1,
            'password' => Hash::make($request->password),
            
        ]);
         
    

        if (get_settings('signup_email_verification') == 1) {
             event(new Registered($user));
             Auth::login($user);
             Session::flash('success', get_phrase('Registered successfully!'));
            return redirect(route('verification.notice'));
        } else {
            // // Log the user in
            // Auth::login($user);
            // Redirect to the appropriate page
            Session::flash('success', get_phrase('Registered successfully!'));
            return redirect(route('login'));
        }
    }
}
