<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/kelas');
        }
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // 3. Menampilkan Halaman Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 4. Proses Register (Untuk User Baru)
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'npm' => 'required|string|unique:users', 
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan ke database dengan role default 'mahasiswa'
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'npm' => $validated['npm'], 
        ]);
        Auth::login($user);

        return redirect('/kelas');
    }

    // 5. Proses Logout (PENTING!)
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Menghapus session agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}