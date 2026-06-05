<div>
    <h2>Crear cuenta de farmacia</h2>

    <p class="small">
        Registra tu farmacia. El sistema creará automáticamente tu espacio privado,
        tu base de datos y tu usuario administrador.
    </p>

    @if ($message)
        <div class="message {{ $messageType }}">
            {{ $message }}
        </div>
    @endif

    @if ($generatedSlug || $generatedDomain || $generatedDatabase)
        <div class="summary-box">
            @if ($generatedSlug)
                <p><strong>Slug:</strong> {{ $generatedSlug }}</p>
            @endif

            @if ($generatedDomain)
                <p><strong>Dominio local:</strong> {{ $generatedDomain }}</p>
            @endif

            @if ($generatedDatabase)
                <p><strong>Base de datos:</strong> {{ $generatedDatabase }}</p>
            @endif
        </div>
    @endif

    <form wire:submit.prevent="register">
        <div>
            <label for="pharmacyName">Nombre de la farmacia</label>
            <input
                type="text"
                id="pharmacyName"
                wire:model="pharmacyName"
                placeholder="Ej. Farmacia San José"
            >

            @error('pharmacyName')
                <div class="message danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="ownerName">Nombre del administrador</label>
            <input
                type="text"
                id="ownerName"
                wire:model="ownerName"
                placeholder="Ej. Juan Pérez"
            >

            @error('ownerName')
                <div class="message danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">Correo del administrador</label>
            <input
                type="email"
                id="email"
                wire:model="email"
                placeholder="correo@farmacia.com"
            >

            @error('email')
                <div class="message danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="phone">Teléfono</label>
            <input
                type="text"
                id="phone"
                wire:model="phone"
                placeholder="Ej. 9511234567"
            >

            @error('phone')
                <div class="message danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                wire:model="password"
                placeholder="Mínimo 8 caracteres"
            >

            @error('password')
                <div class="message danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="passwordConfirmation">Confirmar contraseña</label>
            <input
                type="password"
                id="passwordConfirmation"
                wire:model="passwordConfirmation"
                placeholder="Repite la contraseña"
            >

            @error('passwordConfirmation')
                <div class="message danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled" wire:target="register">
            Crear mi farmacia
        </button>

        <div wire:loading wire:target="register" class="message info" style="margin-top: 14px;">
            Creando farmacia, base de datos y usuario administrador...
        </div>
    </form>
</div>