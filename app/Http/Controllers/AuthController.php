<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'dokter') {
                return redirect()->route('dokter.dashboard');
            }

            return redirect()->route('pasien.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => ['required', 'string', 'max:255'],
            'alamat'   => ['required', 'string', 'max:255'],
            'no_ktp'   => ['required', 'string', 'max:30', 'unique:users,no_ktp'],
            'no_hp'    => ['required', 'string', 'max:20'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $lastPasien = User::where('role', 'pasien')->latest('id')->first();
        $lastNumber = 0;

        if ($lastPasien && $lastPasien->no_rm) {
            $lastNumber = (int) preg_replace('/[^0-9]/', '', $lastPasien->no_rm);
        }

        $newNoRm = 'RM' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        User::create([
            'nama'     => $request->nama,
            'alamat'   => $request->alamat,
            'no_ktp'   => $request->no_ktp,
            'no_hp'    => $request->no_hp,
            'no_rm'    => $newNoRm,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pasien',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}