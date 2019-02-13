<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class Guests
{
    const GUEST_AUTH = 'guest';
    const PHP_AUTH_BEARER = 'Bearer ';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->headers->get('Authorization',self::GUEST_AUTH)==self::GUEST_AUTH){
            $user = User::create(['name'=>'guest2','email'=>'guest2@guest.com','password'=>'test']);
            $token =  $user->createToken('Wyzoo')-> accessToken;
            $request->headers->set('Authorization', self::PHP_AUTH_BEARER.$token);
        }
        
        return $next($request);
    }
}
