<x-layouts.tenant title="Panel de farmacia">
    <div class="card">
        <h2>Panel de farmacia</h2>

        <p class="small">
            Sesión iniciada correctamente dentro del tenant.
        </p>

        <div class="summary-box">
            <p><strong>Usuario:</strong> {{ auth()->user()?->name }}</p>
            <p><strong>Correo:</strong> {{ auth()->user()?->email }}</p>
            <p><strong>Rol:</strong> {{ auth()->user()?->role }}</p>
            <p><strong>Tenant:</strong> {{ tenant('id') }}</p>
        </div>
    </div>
</x-layouts.tenant>