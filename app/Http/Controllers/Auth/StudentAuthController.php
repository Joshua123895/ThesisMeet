<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => "required|string|max:255",
            'email' => "required|email|unique:students,email",
            'password' => "required|min:8|",
            'nim' => "required|regex:/^2[0-9]{9}$/",
            'major' => "required",
        ]);

        $student = Student::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'NIM'       => $request->nim,
            'major'     => $request->major,
        ]);

        Auth::guard('student')->login($student);
        $request->session()->regenerate();
        
        // dd([
        //     'auth_check' => Auth::guard('student')->check(),
        //     'auth_id' => Auth::guard('student')->id(),
        //     'session' => session()->all(),
        // ]);

        event(new Registered($student));
        
        return redirect()->route('verification.notice');
    }
}
