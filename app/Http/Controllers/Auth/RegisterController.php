<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/verify-otp';

    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,customer'],
        ]);
    }

    protected function create(array $data)
    {
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Save user with OTP
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'otp' => $otp, // Store OTP in the database
            'is_verified' => false, // Add an `is_verified` field to User model
        ]);
    }

    protected function registered(Request $request, $user)
    {
        // Send OTP to the user's email
        $this->sendOtp($user);

        // Redirect to OTP verification page
        return redirect($this->redirectTo)->with('email', $user->email);
    }

    protected function sendOtp($user)
    {
        // Use Mail or any service to send the OTP
        Mail::send('emails.otp', ['otp' => $user->otp, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)->subject('Your OTP Verification Code');
        });
    }
    
    // public function resendOtp()
    // {
    //     $user = User::find(Auth::user()->id);
    //     $user->otp = rand(100000, 999999);
    //     $user->save();
    //     Mail::send('emails.otp', ['otp' => $user->otp, 'user' => $user], function ($message) use ($user) {
    //         $message->to($user->email)->subject('Your OTP Verification Code');
    //     });
    // }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->otp == $request->otp) {
            $user->update(['is_verified' => true, 'otp' => null, 'email_verified_at' => now()]);
            return redirect('/home')->with('success', 'Your account is verified.');
        }

        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }
}
