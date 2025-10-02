<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Chuyển hướng sau đăng nhập dựa vào role
        $user = $request->user();
        if ($user) {
            switch ($user->role) {
                case 'superadmin':
                    return redirect()->route('superadmin.users.index');
                case 'admin':
                    return redirect()->route('admin.users.index');
                case 'user':
                default:
                    return redirect()->intended(route('dashboard', absolute: false));
            }
        }
        // Nếu không xác định được user, về trang đăng nhập
        return redirect()->route('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
