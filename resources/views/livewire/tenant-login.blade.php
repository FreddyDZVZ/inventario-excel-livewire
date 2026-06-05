<div>
    <h2>Iniciar sesión</h2>

    <p class="small">
        Ingresa con el correo y contraseña del administrador de la farmacia.
    </p>

    @if ($message)
        <div class="message {{ $messageType }}">
            {{ $message }}
        </div>
    @endif

    <form wire:submit.prevent="login">
        <div>
            <label for="email">Correo</label>
            <input
                type="email"
                id="email"
                wire:model="email"
                placeholder="correo@farmacia.com"
                autocomplete="email"
                autofocus
            >

            @error('email')
                <div class="message danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                wire:model="password"
                placeholder="Tu contraseña"
                autocomplete="current-password"
            >

            @error('password')
                <div class="message danger">{{ $message }}</div>
            @enderror
        </div>

        <label class="checkbox-row">
            <input type="checkbox" wire:model="remember">
            <span>Recordarme</span>
        </label>

        <button type="submit" wire:loading.attr="disabled" wire:target="login">
            Entrar
        </button>

        <div wire:loading wire:target="login" class="message info" style="margin-top: 14px;">
            Validando acceso...
        </div>
    </form>
</div>