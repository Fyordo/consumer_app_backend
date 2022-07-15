<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()){
            return $next($request);
        }
        else if ($request->header('token')){
            $user = User::where('id', '=', $request->header('token'))->first();
            if ($user){
                Auth::login($user);
                return $next($request);
            }
            else{
                return response()->json(['status' => 'Unauthenticated'], 401);
            }
        }
        return response()->json(['status' => 'Unauthenticated'], 401);
    }
}
