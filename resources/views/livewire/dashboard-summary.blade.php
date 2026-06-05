<div class="dashboard-grid">
    <div class="welcome-card">
        <div>
            <h2>Panel de inventario</h2>
            <p>
                Administra tu inventario de forma rápida: sube tu Excel, escanea productos
                y revisa lo que ya se guardó.
            </p>
        </div>

        <a href="{{ route('scanner.index') }}" class="main-action">
            Escanear ahora
        </a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <span>Total productos</span>
            <strong>{{ $totalProducts }}</strong>
        </div>

        <div class="stat-card warning-stat">
            <span>Sin precio</span>
            <strong>{{ $productsWithoutPrice }}</strong>
        </div>

        <div class="stat-card warning-stat">
            <span>Sin existencia</span>
            <strong>{{ $productsWithoutStock }}</strong>
        </div>

        <div class="stat-card">
            <span>Agregados manualmente</span>
            <strong>{{ $manualProducts }}</strong>
        </div>

        <div class="stat-card">
            <span>Encontrados en internet</span>
            <strong>{{ $internetProducts }}</strong>
        </div>
    </div>

    <div class="quick-actions">
        <a href="{{ route('inventory.upload') }}" class="quick-card">
            <div class="quick-icon">📄</div>
            <div>
                <h3>Subir Excel</h3>
                <p>Importa tu inventario desde un archivo.</p>
            </div>
        </a>

        <a href="{{ route('scanner.index') }}" class="quick-card primary">
            <div class="quick-icon">🔍</div>
            <div>
                <h3>Escáner rápido</h3>
                <p>Escanea códigos y agrega productos al momento.</p>
            </div>
        </a>

        <a href="{{ route('products.index') }}" class="quick-card">
            <div class="quick-icon">📦</div>
            <div>
                <h3>Ver productos</h3>
                <p>Consulta todo lo que ya está guardado.</p>
            </div>
        </a>
    </div>
</div>