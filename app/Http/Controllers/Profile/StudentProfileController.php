<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function home() {
        return view('student.home', [
            'user' => Auth::guard('student')->user()
        ]);
    }

    public function profile() {
        return view('student.profile.show', [
            'user' => Auth::guard('student')->user()
        ]);
    }

    public function edit() {
        return view('student.profile.edit', [
            'user' => Auth::guard('student')->user()
        ]);
    }

    public function update(Request $request) {
        $user = Auth::guard('student')->user(); 

        $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nim' => "required|regex:/^2[0-9]{9}$/",
            'major' => 'required',
        ]);

        $user->name = $request->name;
        $user->major = $request->major;
        $user->NIM = $request->nim;

        if ($request->hasFile('photo')) {
            if (!empty($user->image_path)) {
                Storage::disk('public')->delete($user->image_path);
            }

            $user->image_path = $request->file('photo')->storeAs(
                'students',
                uniqid() . '.' . $request->photo->extension(),
                'public'
            );
        }

        $user->save();

        return redirect()
            ->route('student.profile.show')
            ->with('success', __('home.profile updated'));
    }

    public function aboutUs() {
        return view('about-us', [
            'user' => Auth::guard('student')->user()
        ]);
    }
}
