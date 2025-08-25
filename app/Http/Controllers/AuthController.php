<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show admin login form
    public function showLogin()
    {
        return view('auth.admin-login');
    }

    // Handle admin login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('toast_success', 'Login berhasil! Selamat datang Admin.');
            } else {
                Auth::logout();
                return back()->with('error', 'Akses ditolak. Anda bukan admin.');
            }
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('toast_success', 'Logout berhasil.');
    }

    // Show admin registration form
    public function showRegister()
    {
        return view('auth.admin-register');
    }

    // Handle admin registration (only accessible by existing admin)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.dashboard')->with('toast_success', 'Admin baru berhasil ditambahkan.');
    }
}
