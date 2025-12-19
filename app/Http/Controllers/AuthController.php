<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Cek manual session
        if (session()->has('user_id')) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',  
            'password' => 'required',
        ]);

        // Cari user manual
        $user = User::where('username', $request->username)->first();

        // Validasi password manual
        if ($user && Hash::check($request->password, $user->password)) {
            
            // Simpan ke session MANUAL
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'role' => $user->role,
                'logged_in' => true,
            ]);
            
            // Save paksa
            session()->save();
            
            \Log::info('Login manual berhasil:', [
                'user_id' => $user->id,
                'session_id' => session()->getId(),
                'session_has_user' => session()->has('user_id'),
            ]);
            
            // Redirect dengan success message
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',  
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        session()->flush();
        session()->regenerate();
        
        return redirect('/login');
    }
}