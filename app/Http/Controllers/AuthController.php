<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Coba login dengan username dan pastikan user aktif
        if (Auth::attempt(array_merge($credentials, ['activated' => 1]))) {
            $request->session()->regenerate();
            
            // Update last_login
            Auth::user()->update([
                'last_login' => now()
            ]);

            // Redirect berdasarkan role
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'username' => 'Username atau password salah, atau akun tidak aktif.',
        ])->onlyInput('username');
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole($user)
    {
        if (!$user->role) {
            return redirect('/dashboard');
        }

        switch ($user->role->name) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'manager_it':
                return redirect('/manager/dashboard');
            case 'pic_unit':
                return redirect('/pic/dashboard');
            case 'pelaksana':
                return redirect('/pelaksana/dashboard');
            default:
                return redirect('/dashboard');
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}