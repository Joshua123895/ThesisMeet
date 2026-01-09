<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Find the token record
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenRecord) {
            return back()->withErrors(['email' => __('auth.invalid token')]);
        }

        // Verify the token
        if (!Hash::check($request->token, $tokenRecord->token)) {
            return back()->withErrors(['email' => __('auth.invalid token')]);
        }

        // Check if token is expired (1 hour)
        if (now()->diffInMinutes($tokenRecord->created_at) > 60) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return back()->withErrors(['email' => __('auth.expired token')]);
        }

        // Find and update the user based on user_type
        $user = $tokenRecord->user_type === 'student'
            ? Student::where('email', $request->email)->first()
            : Lecturer::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => __('auth.email not found')]);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')->with('status', __('auth.password has been reset'));
    }
}
