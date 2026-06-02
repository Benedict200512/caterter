<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    /**
     * Show the Registration Form.
     */
    public function showRegister()
    {
        return view('register');
    }

    /**
     * Handle the Registration Data and notify Admins.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'date_of_birth' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'address'       => 'required|string|max:500',
            'phone'         => [
                'required',
                'string',
                'regex:/^(\+63|0)[0-9]{10}$/',
                'unique:users,phone',
            ],
            'username'      => [
                'required',
                'string',
                'min:6',
                'max:30',
                'regex:/^[a-zA-Z0-9_]+$/',
                'unique:users,username',
            ],
            'password'      => [
                'required',
                'string',
                'min:8',
                'max:64',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+\[\]{};\':"\\|,.<>\/?`~])[^\s]+$/',
            ],
        ], [
            'name.required'          => 'Your full name is required.',
            'email.required'         => 'An email address is required.',
            'email.email'            => 'Please enter a valid email address.',
            'email.unique'           => 'This email address is already registered.',
            'date_of_birth.required' => 'Your date of birth is required.',
            'date_of_birth.before_or_equal' => 'You must be at least 18 years old to register.',
            'address.required'       => 'Your address is required.',
            'phone.required'         => 'A mobile number is required.',
            'phone.regex'            => 'Please enter a valid Philippine mobile number (e.g. 09XX XXX XXXX).',
            'phone.unique'           => 'This mobile number is already registered.',
            'username.required'      => 'A username is required.',
            'username.min'           => 'Username must be at least 6 characters.',
            'username.max'           => 'Username may not exceed 30 characters.',
            'username.regex'         => 'Username may only contain letters, numbers, and underscores.',
            'username.unique'        => 'This username is already taken. Please choose another.',
            'password.required'      => 'A password is required.',
            'password.min'           => 'Password must be at least 8 characters.',
            'password.max'           => 'Password may not exceed 64 characters.',
            'password.confirmed'     => 'Passwords do not match.',
            'password.regex'         => 'Password must contain at least one uppercase letter, one lowercase letter, one number, one special character, and no spaces.',
        ]);

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'address'       => $request->address,
            'phone'         => $request->phone,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'role'          => 'user',
        ]);

        // Notify admins about new user
        $admins = User::where('role', 'admin')->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new AppNotification([
                'title'   => 'New User Registered',
                'message' => $user->name . ' (@' . $user->username . ') has joined the platform.',
                'url'     => url('/admin/users'),
                'type'    => 'info',
            ]));
        }

        Auth::login($user);

        return redirect('/')->with('success', 'Account created successfully! Welcome to CaterConnect.');
    }

    /**
     * Show the Login Form.
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Handle Login Attempt.
     * Supports login via email OR username.
     *
     * UPDATED: Role-based redirect after login.
     *   - Caterers → /dashboard (their caterer dashboard)
     *   - Admins   → /dashboard (admin dashboard)
     *   - Customers → / (homepage/marketplace)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Please enter your email or username.',
            'password.required' => 'Please enter your password.',
        ]);

        $loginValue = $request->email;

        // Determine if the user is logging in with email or username
        $field = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field     => $loginValue,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Role-based redirect
            if (in_array($user->role, ['caterer', 'admin'])) {
                return redirect()->intended('/dashboard')->with('success', 'Welcome back, ' . explode(' ', $user->name)[0] . '!');
            }

            // Customer → homepage
            return redirect()->intended('/')->with('success', 'Welcome back, ' . explode(' ', $user->name)[0] . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}