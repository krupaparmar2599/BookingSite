<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function login()
    {
        return view('auth.login');
    }


    public function logincheck(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        if (!\Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

        if ($user->is_verified == 0) {
            return redirect()->back()->with('error', 'Please verify your account first.');
        }


        \Auth::login($user);

        return redirect()->route('booking.process')->with('success', 'You have login successfully.');
    }

}
