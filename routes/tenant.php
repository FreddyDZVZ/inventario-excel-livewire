<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('tenant.dashboard');
        }

        return redirect()->route('tenant.login');
    })->name('tenant.home');

    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect()->route('tenant.dashboard');
        }

        return view('auth.tenant-login');
    })->name('tenant.login');

    Route::post('/login', function (Request $request) {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Escribe tu correo.',
            'email.email' => 'El correo no es válido.',
            'password.required' => 'Escribe tu contraseña.',
        ]);

        $email = strtolower(trim($validated['email']));

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->where('is_active', true)
            ->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors([
                    'email' => 'El correo o la contraseña son incorrectos.',
                ])
                ->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->route('tenant.dashboard');
    })->name('tenant.login.submit');

    Route::post('/logout', function (Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tenant.login');
    })->middleware('auth')->name('tenant.logout');

    Route::view('/inicio', 'tenant.dashboard')
        ->middleware('auth')
        ->name('tenant.dashboard');
});