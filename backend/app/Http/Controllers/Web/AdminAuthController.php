<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function showRegister()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 2,
        ]);
        $request->session()->put('admin_id', $admin->id);
        $request->session()->put('admin_name', $admin->name);
        return redirect('/admin')->with('status', 'Registration successful');
    }

    public function showForgotPassword()
    {
        return view('admin.forgot');
    }

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:50',
        ]);
        // In a production app, send a reset link. Here we flash a status.
        return redirect('/admin/login')->with('status', 'If the email exists, a reset link was sent.');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:100',
        ]);

        $admin = User::where('email', $validated['email'])->where('role_id', 2)->first();
        if (!$admin || !Hash::check($validated['password'], $admin->password)) {
            return redirect('/admin/login')->withErrors(['Invalid credentials']);
        }

        $request->session()->put('admin_id', $admin->id);
        $request->session()->put('admin_name', $admin->name);
        return redirect('/admin');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id','admin_name']);
        return redirect('/');
    }
}
