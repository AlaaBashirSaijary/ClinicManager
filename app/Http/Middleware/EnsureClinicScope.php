<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClinicScope
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->clinic_id) {
            auth()->logout();

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'حسابك غير مربوط بعيادة. تواصل مع المسؤول.']);
        }

        return $next($request);
    }
}
