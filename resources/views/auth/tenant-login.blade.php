<x-layouts.guest title="Iniciar sesión">
    <div class="guest-card">
        <h2>Iniciar sesión</h2>

        <p class="small">
            Ingresa con el correo y contraseña del administrador de la farmacia.
        </p>

        @if ($errors->any())
            <div class="message danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('tenant.login.submit') }}">
            @csrf

            <div>
                <label for="email">Correo</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="correo@farmacia.com"
                    autocomplete="email"
                    autofocus
                    required
                >
            </div>

            <div>
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Tu contraseña"
                    autocomplete="current-password"
                    required
                >
            </div>

            <label class="checkbox-row">
                <input type="checkbox" name="remember" value="1">
                <span>Recordarme</span>
            </label>

            <button type="submit">
                Entrar
            </button>
        </form>
    </div>
</x-layouts.guest>