<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LecturerProfileController extends Controller
{
    public function home() {
        return view('lecturer.home', [
            'user' => Auth::guard('lecturer')->user()
        ]);
    }

    public function profile() {
        return view('lecturer.profile.show', [
            'user' => Auth::guard('lecturer')->user()
        ]);
    }

    public function edit() {
        return view('lecturer.profile.edit', [
            'user' => Auth::guard('lecturer')->user()
        ]);
    }
    
    public function update(Request $request) {
        $user = Auth::guard('lecturer')->user(); 

        $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'profile' => 'required',
            'phone' => 'required|regex:/^[0-9]{12}$/',
        ]);

        $user->name = $request->name;
        $user->profile = $request->profile;
        $user->phone = $request->phone;

        if ($request->hasFile('photo')) {
            if (!empty($user->image_path)) {
                Storage::disk('public')->delete($user->image_path);
            }

            $user->image_path = $request->file('photo')->storeAs(
                'lecturers',
                uniqid() . '.' . $request->photo->extension(),
                'public'
            );
        }
        
        $user->save();

        return redirect()
            ->route('lecturer.profile.show')
            ->with('success', __('home.profile updated'));
    }

    public function aboutUs() {
        return view('about-us', [
            'user' => Auth::guard('lecturer')->user()
        ]);
    }
}
