<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user('user');

        if ($user && $user->status === 'blocked') {
            auth('user')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('user.login')->withErrors([
                'identity' => 'Akun Anda diblokir oleh admin.'
            ]);
        }

        return $next($request);
    }
}

