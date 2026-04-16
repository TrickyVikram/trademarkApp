<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        // If already logged in as admin, redirect to dashboard
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }

        return view('auth.admin-login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Attempt login with admin guard
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            // Log successful admin login
            Log::info('Admin login successful: ' . $request->email);

            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => route('admin.dashboard')
            ]);
        }

        // Log failed login attempt
        Log::warning('Admin login failed: ' . $request->email);

        return response()->json([
            'success' => false,
            'message' => 'These credentials do not match our records.'
        ], 401);
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Logged out successfully');
    }

    /**
     * Check admin authentication status
     */
    public function checkAuth()
    {
        if (Auth::guard('admin')->check()) {
            return response()->json([
                'authenticated' => true,
                'admin' => Auth::guard('admin')->user()
            ]);
        }

        return response()->json([
            'authenticated' => false
        ]);
    }
}
