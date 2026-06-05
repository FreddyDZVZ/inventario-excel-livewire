<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Panel administrador' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @livewireStyles

    <style>
        :root {
            --blue: #0f3d7a;
            --blue-light: #1d4ed8;
            --bg: #f3f6fb;
            --text: #1f2937;
            --muted: #64748b;
            --border: #e2e8f0;
            --green: #15803d;
            --red: #991b1b;
            --yellow: #b45309;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            margin: 0;
            color: var(--text);
        }

        .tenant-shell {
            display: grid;
            grid-template-columns: 270px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, #0f3d7a, #082f68);
            color: white;
            padding: 24px 18px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .brand {
            margin-bottom: 26px;
            padding: 0 8px;
        }

        .brand h1 {
            margin: 0;
            font-size: 22px;
        }

        .brand p {
            margin: 6px 0 0;
            font-size: 13px;
            opacity: .85;
        }

        .tenant-user {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.16);
            padding: 14px;
            border-radius: 16px;
            margin-bottom: 22px;
        }

        .tenant-user strong {
            display: block;
            font-size: 14px;
        }

        .tenant-user span {
            display: block;
            font-size: 12px;
            opacity: .82;
            margin-top: 4px;
        }

        .nav-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            opacity: .65;
            margin: 20px 8px 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            color: white;
            text-decoration: none;
            padding: 12px 13px;
            border-radius: 13px;
            font-size: 14px;
            margin-bottom: 6px;
            background: transparent;
        }

        .nav-link:hover {
            background: rgba(255,255,255,.14);
        }

        .nav-link.active {
            background: white;
            color: var(--blue);
            font-weight: bold;
        }

        .nav-icon {
            width: 24px;
            text-align: center;
            font-size: 18px;
        }

        .logout-form {
            margin: 20px 0 0;
        }

        .logout-button {
            width: 100%;
            border: none;
            background: rgba(153, 27, 27, .9);
            color: white;
            padding: 12px 13px;
            border-radius: 13px;
            cursor: pointer;
            font-size: 14px;
            text-align: left;
        }

        .logout-button:hover {
            background: #7f1d1d;
        }

        .main {
            padding: 26px;
        }

        .topbar {
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin-bottom: 22px;
            box-shadow: 0 8px 24px rgba(15, 61, 122, .06);
        }

        .topbar h2 {
            margin: 0;
            color: var(--blue);
            font-size: 22px;
        }

        .topbar p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .quick-sale-button {
            background: var(--green);
            color: white;
            text-decoration: none;
            padding: 13px 18px;
            border-radius: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        .quick-sale-button:hover {
            background: #166534;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: 0 8px 24px rgba(15, 61, 122, .06);
        }

        .small {
            color: var(--muted);
            font-size: 13px;
        }

        .summary-box {
            background: #eef5ff;
            border: 1px solid #bfdbfe;
            color: #1e3a8a;
            padding: 13px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
        }

        .summary-box p {
            margin: 6px 0;
        }

        @media (max-width: 900px) {
            .tenant-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                height: auto;
            }

            .main {
                padding: 16px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .quick-sale-button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="tenant-shell">
    <aside class="sidebar">
        <div class="brand">
            <h1>FarmaPOS</h1>
            <p>Punto de venta inteligente</p>
        </div>

        <div class="tenant-user">
            <strong>{{ auth()->user()?->name }}</strong>
            <span>{{ auth()->user()?->email }}</span>
            <span>Rol: {{ auth()->user()?->role }}</span>
        </div>

        <div class="nav-title">Operación</div>

        <a href="{{ route('tenant.admin.dashboard') }}" class="nav-link {{ request()->routeIs('tenant.admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">🏠</span>
            <span>Inicio</span>
        </a>

        <a href="{{ route('tenant.pos') }}" class="nav-link {{ request()->routeIs('tenant.pos') ? 'active' : '' }}">
            <span class="nav-icon">🧾</span>
            <span>Punto de venta</span>
        </a>

        <a href="{{ route('tenant.products') }}" class="nav-link {{ request()->routeIs('tenant.products') ? 'active' : '' }}">
            <span class="nav-icon">💊</span>
            <span>Productos</span>
        </a>

        <a href="{{ route('tenant.inventory') }}" class="nav-link {{ request()->routeIs('tenant.inventory') ? 'active' : '' }}">
            <span class="nav-icon">📦</span>
            <span>Inventario</span>
        </a>

        <a href="{{ route('tenant.sales') }}" class="nav-link {{ request()->routeIs('tenant.sales') ? 'active' : '' }}">
            <span class="nav-icon">📈</span>
            <span>Ventas</span>
        </a>

        <a href="{{ route('tenant.cash') }}" class="nav-link {{ request()->routeIs('tenant.cash') ? 'active' : '' }}">
            <span class="nav-icon">💵</span>
            <span>Caja</span>
        </a>

        <div class="nav-title">Administración</div>

        <a href="{{ route('tenant.reports') }}" class="nav-link {{ request()->routeIs('tenant.reports') ? 'active' : '' }}">
            <span class="nav-icon">📊</span>
            <span>Reportes</span>
        </a>

        <a href="{{ route('tenant.users') }}" class="nav-link {{ request()->routeIs('tenant.users') ? 'active' : '' }}">
            <span class="nav-icon">👥</span>
            <span>Usuarios</span>
        </a>

        <a href="{{ route('tenant.settings') }}" class="nav-link {{ request()->routeIs('tenant.settings') ? 'active' : '' }}">
            <span class="nav-icon">⚙️</span>
            <span>Configuración</span>
        </a>

        <form method="POST" action="{{ route('tenant.logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-button">
                Cerrar sesión
            </button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h2>{{ $title ?? 'Panel administrador' }}</h2>
                <p>Administra tu farmacia, ventas, inventario y operación diaria.</p>
            </div>

            <a href="{{ route('tenant.pos') }}" class="quick-sale-button">
                Nueva venta
            </a>
        </div>

        {{ $slot }}
    </main>
</div>

@livewireScripts

</body>
</html>