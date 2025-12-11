<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:100',
        ]);
        if (!Auth::attempt($validated)) {
            return redirect('/login')->withErrors(['Invalid credentials']);
        }
        $request->session()->regenerate();
        $u = Auth::user();
        if ((int)($u->role_id ?? 1) === 2) {
            return redirect('/admin');
        }
        return redirect('/dashboard');
    }

    public function showRegister()
    {
        return view('user.register');
    }

    public function sendRegisterOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:100|unique:users,email',
        ]);
        $code = random_int(100000, 999999);
        OtpCode::create([
            'email' => $validated['email'],
            'code' => (string)$code,
            'purpose' => 'signup',
            'expires_at' => now()->addMinutes(5),
        ]);
        $mailError = null;
        $sentDev = false;
        try {
            Mail::raw('Your verification code: '.$code."\nThis code expires in 5 minutes.", function($m) use ($validated) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to($validated['email'])->subject('St. Joseph Shrine - Verification Code');
            });
        } catch (\Throwable $e) {
            $mailError = $e->getMessage();
            logger()->error('Register OTP mail send failed: '.$mailError);
        }
        $sentDev = app()->environment('local');
        if ($request->ajax()) {
            if ($sentDev) {
                return response()->json(['status' => 'sent_dev', 'dev_code' => (string)$code]);
            }
            if ($mailError) {
                return response()->json(['status' => 'error', 'message' => $mailError], 500);
            }
            return response()->json(['status' => 'sent']);
        }
        $msg = $mailError ? 'Verification code generated. Email delivery failed.' : 'Verification code sent';
        $back = back()->with('status', $msg);
        if ($sentDev) {
            $back->with('dev_code', (string)$code);
        }
        return $back;
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 1,
        ]);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect('/')->with('status', 'Registration complete');
    }

    public function showForgotPassword()
    {
        return view('user.forgot');
    }

    public function sendResetOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:100',
        ]);
        $code = random_int(100000, 999999);
        OtpCode::create([
            'email' => $validated['email'],
            'code' => (string)$code,
            'purpose' => 'reset',
            'expires_at' => now()->addMinutes(5),
        ]);
        User::where('email', $validated['email'])->update([
            'otp_code' => (string)$code,
            'otp_sent_at' => now(),
        ]);
        $mailError = null;
        $sentDev = false;
        try {
            Mail::raw('Your password reset code: '.$code."\nThis code expires in 5 minutes.", function($m) use ($validated) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to($validated['email'])->subject('St. Joseph Shrine - Reset Code');
            });
        } catch (\Throwable $e) {
            $mailError = $e->getMessage();
            logger()->error('Reset OTP mail send failed: '.$mailError);
        }
        $sentDev = app()->environment('local');
        if ($request->ajax()) {
            if ($sentDev) {
                return response()->json(['status' => 'sent_dev', 'dev_code' => (string)$code, 'redirect' => '/reset-password?email='.urlencode($validated['email'])]);
            }
            if ($mailError) {
                return response()->json(['status' => 'error', 'message' => $mailError], 500);
            }
            return response()->json(['status' => 'sent', 'redirect' => '/reset-password?email='.urlencode($validated['email'])]);
        }
        $redir = redirect('/reset-password?email='.urlencode($validated['email']))
            ->with('status', $mailError ? 'Reset code generated. Email delivery failed.' : 'Reset code sent');
        if ($sentDev) {
            $redir->with('dev_code', (string)$code);
        }
        return $redir;
    }

    public function showReset(Request $request)
    {
        $email = (string) $request->query('email');
        return view('user.reset', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:100',
            'code' => 'required|string|min:6|max:6',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $otp = OtpCode::where('email', $validated['email'])
            ->where('purpose', 'reset')
            ->whereNull('consumed_at')
            ->latest()->first();
        if (!$otp || $otp->code !== $validated['code'] || now()->greaterThan($otp->expires_at)) {
            return back()->withErrors(['Invalid or expired reset code']);
        }
        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return back()->withErrors(['No account found']);
        }
        $user->update(['password' => Hash::make($validated['password'])]);
        $otp->update(['consumed_at' => now()]);
        return redirect('/login')->with('status', 'Password updated');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
