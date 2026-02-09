<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
      
        $request->authenticate();
       
        $request->session()->regenerate();
        // Session::flash('success', get_phrase('Welcome back ____' ,user('name')));

        $message = get_phrase('Welcome back ____');
        $message = str_replace('____', user('name'), $message);
        Session::flash('success', $message);

        if(user('role') == 1){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()-> route('customer.wishlist');
        }
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
