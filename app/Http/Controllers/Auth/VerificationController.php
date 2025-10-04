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

class VerificationController extends Controller
{

    public function verificationForm()
    {
        return view('auth.verify');
    }

    public function verificationCheck(Request $request)
    {
        $code = $request->digit1 . $request->digit2 . $request->digit3 . $request->digit4;

        $userId = session('verify_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        if ($user->verification_code === $code) {
            $user->is_verified = true;
            $user->verification_code = null;
            $user->save();

            session()->forget('verify_user_id');
            return redirect()->route('booking.process')->with([
                'success' => 'You have registered successfully.',
                'role'    => 'customer'
            ]);
        }

        return back()->with('error', 'Invalid verification code. Please try again.');
    }
}
