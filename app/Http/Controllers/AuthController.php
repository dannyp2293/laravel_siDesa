<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
        {
            return view('pages.auth.login');
        }
    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $userStatus = Auth::user()->status;

             if ($userStatus =='submitted') {
                return back()->withErrors([
                    'email' => 'Akun anda masih menunggu persetujuan admin.'
                ]);

             } else if ($userStatus == 'rejected') {
                return back()->withErrors([
                    'email' => 'Akun anda telah ditolak admin.'
                ]);
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Terjadi kesalahan periksa kemabali email atau password anda.',
        ])->onlyInput('email');

    }
    public function  registerView()
    {
        return view('pages.auth.register');
    }
    public function register(Request $request)
    {
$validated = $request->validated([
        'name' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = New User();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password'));
    }

    public function logout(Request $request)
{

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');

}
}
