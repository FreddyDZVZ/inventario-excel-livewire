<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Panel de farmacia' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @livewireStyles

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            margin: 0;
            padding: 30px;
        }

        .app-container {
            max-width: 1050px;
            margin: auto;
        }

        .topbar {
            background: #0f3d7a;
            color: white;
            padding: 18px 24px;
            border-radius: 18px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }

        .topbar h1 {
            margin: 0;
            font-size: 22px;
        }

        .topbar nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .topbar a,
        .topbar button {
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,.15);
            padding: 9px 13px;
            border-radius: 10px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .topbar a:hover,
        .topbar button:hover {
            background: rgba(255,255,255,.25);
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .small {
            color: #64748b;
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

        button {
            background: #0f3d7a;
            color: white;
            border: none;
            padding: 13px 22px;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
        }

        button:hover {
            background: #0c3264;
        }

        @media (max-width: 700px) {
            body {
                padding: 16px;
            }

            .topbar {
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<div class="app-container">
    <div class="topbar">
        <h1>Panel de farmacia</h1>

        <nav>
            <a href="{{ route('tenant.dashboard') }}">Inicio</a>

            <form method="POST" action="{{ route('tenant.logout') }}" style="margin:0;">
                @csrf
                <button type="submit">
                    Cerrar sesión
                </button>
            </form>
        </nav>
    </div>

    {{ $slot }}
</div>

@livewireScripts

</body>
</html>