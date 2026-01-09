<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LecturerAuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers,email',
            'password' => 'required|min:8',
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'profile' => 'required',
            'phone' => 'required|regex:/^[0-9]{12}$/',
        ]);

        // Store image
        $path = $request->file('photo')->storeAs(
            'lecturers',
            uniqid() . '.' . $request->photo->extension(),
            'public'
        );
        
        $lecturer = Lecturer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'profile' => $request->profile,
            'image_path' => $path,
        ]);

        Auth::guard('lecturer')->login($lecturer);
        $request->session()->regenerate();

        event(new Registered($lecturer));

        return redirect()->route('verification.notice');
    }
}
