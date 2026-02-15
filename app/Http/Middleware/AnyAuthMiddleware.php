<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnyAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(user('role') == 2 && user('is_agent') == 1 || user('role') == 1){
            return $next($request);
        }else{
            if (get_settings('signup_email_verification') == 1 && !user('email_verified_at')) {
                return redirect(route('verification.notice'));
            }
            return redirect('/');
        }
    }
}
