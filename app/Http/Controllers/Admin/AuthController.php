<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Render standalone admin login page (no header/footer)
        return view('layouts.auth');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Try database authentication first
        try {
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome back!');
            }
        } catch (\Exception $e) {
            // Database connection failed, fall back to session auth
        }

        // Fallback to hardcoded admin credentials for demo
        if ($credentials['email'] === 'admin@electro.com' && $credentials['password'] === 'password123') {
            // Create a simple session-based auth
            $request->session()->put('admin_authenticated', true);
            $request->session()->put('admin_user', [
                'name' => 'Admin User',
                'email' => 'admin@electro.com'
            ]);
            
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Logout from Laravel Auth if authenticated
        if (Auth::check()) {
            Auth::logout();
        }
        
        // Clear session-based auth
        $request->session()->forget(['admin_authenticated', 'admin_user']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }

    public function createAdminUser()
    {
        // Create admin user if it doesn't exist
        $admin = User::firstOrCreate(
            ['email' => 'admin@electro.com'],
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        return response()->json([
            'message' => 'Admin user created successfully',
            'email' => $admin->email,
            'password' => 'password123'
        ]);
    }
}
