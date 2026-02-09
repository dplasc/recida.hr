<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(user('role') == 2){
             if (get_settings('signup_email_verification') == 1){
                if(user('email_verified_at') ){
                    return $next($request);
                }else{
                    return redirect(route('verification.notice'));
                }
             }else{
                return $next($request);
             }
            
        }else{
            return redirect('/');
        }
    }
}
