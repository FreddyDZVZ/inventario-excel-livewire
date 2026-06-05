<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class TenantLogin extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public ?string $message = null;

    public string $messageType = 'danger';

    public function login()
    {
        $validated = $this->validate([
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

        if (! $user) {
            $this->messageType = 'danger';
            $this->message = 'El correo o la contraseña son incorrectos.';

            return;
        }

        if (! Hash::check($validated['password'], $user->password)) {
            $this->messageType = 'danger';
            $this->message = 'El correo o la contraseña son incorrectos.';

            return;
        }

        Auth::login($user, $this->remember);

        request()->session()->regenerate();

        return redirect()->route('tenant.dashboard');
    }

    public function render()
    {
        return view('livewire.tenant-login');
    }
}