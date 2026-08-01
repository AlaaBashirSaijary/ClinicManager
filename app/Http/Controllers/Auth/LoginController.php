<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'أدخل البريد الإلكتروني.',
            'email.email' => 'البريد الإلكتروني غير صحيح.',
            'password.required' => 'أدخل كلمة المرور.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'بيانات الدخول غير صحيحة.']);
        }

        $request->session()->regenerate();

        if (! Auth::user()->clinic_id) {
            Auth::logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'حسابك غير مربوط بعيادة. تواصل مع المسؤول.']);
        }

        return redirect()->intended(route('home'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
