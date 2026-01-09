<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
    {
    public function login(Request $request) {
        Auth::guard('student')->logout();
        Auth::guard('lecturer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $credentials = $request->only('email', 'password');
        
        // dd($request->all());

        // dd(
        //     Auth::guard('student')->attempt($credentials),
        //     Auth::guard('lecturer')->attempt($credentials)
        // );

        if ($request->role === 'student') {
            if (Auth::guard('student')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('student.home');
            }
        }

        if ($request->role === 'lecturer') {
            if (Auth::guard('lecturer')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('lecturer.home');
            }
        }

        return back()->withErrors(['email' => ucfirst(__('auth.invalid credentials'))]);
    }
    
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        Auth::guard('lecturer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function verifyNotice(Request $request) {
        // dd([
        //     'user' => $request->user(),
        //     'guard_student' => Auth::guard('student')->check(),
        //     'guard_lecturer' => Auth::guard('lecturer')->check(),
        // ]);
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route(
                Auth::guard('student')->check()
                    ? 'student.home'
                    : 'lecturer.home'
            );
        }

        return view('auth.verify-email');
    }
    
    public function verify(EmailVerificationRequest $request) {
        $request->fulfill();
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.home')->with('success', ucwords(__('auth.success log in student')));
        }
        if (Auth::guard('lecturer')->check()) {
            return redirect()->route('lecturer.home')->with('success', ucwords(__('auth.success log in lecturer')));;
        }
        return redirect('/login')->with('success', ucwords(__('auth.success log in')));
    }

    public function verifySend(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', __('verification email sent'));
    }
}
