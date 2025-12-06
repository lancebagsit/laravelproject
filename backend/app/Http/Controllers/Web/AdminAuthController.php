<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $validated['email'])->first();
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

