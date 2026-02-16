<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                return redirect('/admin')->with('success', 'Selamat datang, Admin! Panel manajemen aktif.');
            }
            
            return redirect('/')->with('success', 'Halo ' . Auth::user()->name . ', selamat belanja!');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function showRegister() {
        return view('register');
    }

    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'role' => 'required',
            'admin_code' => 'nullable'
        ]);

        $finalRole = 'user';
        $kodeRahasiaAdmin = "ADMIN123";

        if ($request->role == 'admin') {
            $isEmailValid = str_contains(strtolower($request->email), '@admin.com');
            $isCodeValid = ($request->admin_code === $kodeRahasiaAdmin);

            if ($isEmailValid && $isCodeValid) {
                $finalRole = 'admin';
            } else {
                $errorMsg = !$isEmailValid ? 'Email wajib gunakan domain @admin.com!' : 'Kode Rahasia Admin Salah!';
                return back()->withInput()->with('error', $errorMsg);
            }
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $finalRole,
        ]);

        Auth::login($user); 
        
        if ($finalRole == 'admin') {
            return redirect('/admin')->with('success', 'Akun Admin aktif! Panel manajemen siap digunakan.');
        }

        return redirect('/')->with('success', 'Pendaftaran berhasil sebagai Pembeli!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Berhasil logout!');
    }
}