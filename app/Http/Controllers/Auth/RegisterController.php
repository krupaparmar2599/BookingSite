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

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|alpha|min:3',
            'last_name'  => 'required|alpha|min:3',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6|confirmed',
            // 'role'       => 'required|in:customer,admin',
        ], [
            'first_name.required' => 'First name is required',
            'first_name.alpha'    => 'First name must contain only letters',
            'first_name.min'      => 'First name must be at least 3 characters',

            'last_name.required'  => 'Last name is required',
            'last_name.alpha'     => 'Last name must contain only letters',
            'last_name.min'       => 'Last name must be at least 3 characters',

            'email.required'      => 'Email is required',
            'email.email'         => 'Enter a valid email address',
            'email.unique'        => 'This email is already registered',

            'password.required'   => 'Password is required',
            'password.min'        => 'Password must be at least 6 characters',
            'password.confirmed'  => 'Passwords do not match',

            // 'role.required'       => 'Please select user type',
            // 'role.in'             => 'Invalid role selected',
        ]);

        $verificationCode = rand(1000, 9999);

        $user = User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            // 'role'              => $request->role,
            'verification_code' => $verificationCode,
            'is_verified'       => false,
        ]);
        session(['verify_user_id' => $user->id]);
Auth::login($user); 

        Mail::to($user->email)->queue(new VerifyEmail($verificationCode));

        return redirect()->route('verify.form')
            ->with('success', 'Registration successful! Please check your email for verification code.');
            
    }

}
