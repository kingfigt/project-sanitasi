<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        \Illuminate\Support\Facades\Log::info('Web Login Attempt', ['username' => $credentials['username'], 'password' => $credentials['password']]);
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            \Illuminate\Support\Facades\Log::info('Web Login Success');
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        \Illuminate\Support\Facades\Log::warning('Web Login Failed');

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function loginApi(Request $request)
    {
        try {
            $user = User::where('username', $request->username)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Berhasil',
                    'data' => $user
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Username atau Password salah'
            ], 401);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'fatal_error',
                'message' => 'Penyebab: ' . $e->getMessage() . ' (Baris ' . $e->getLine() . ')'
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}