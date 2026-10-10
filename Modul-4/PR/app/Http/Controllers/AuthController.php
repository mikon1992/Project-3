<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:100', 'unique:users,email'],
            'username'     => ['required', 'string', 'max:50', 'unique:users,username'],
            'password'     => ['required', 'string', 'min:6', 'confirmed'],
            'no_hp'        => ['nullable', 'string', 'max:15'],
            'alamat'       => ['nullable', 'string'],
        ]);

        $user = User::create([
            'nama_lengkap' => $data['nama_lengkap'],
            'email'        => $data['email'],
            'username'     => $data['username'],
            'password'     => Hash::make($data['password']),
            'no_hp'        => $data['no_hp'] ?? null,
            'alamat'       => $data['alamat'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('products.index')->with('success', 'Akun berhasil dibuat. Selamat belanja!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('products.index'))->with('success', 'Berhasil login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('products.index')->with('success', 'Berhasil logout.');
    }
}
