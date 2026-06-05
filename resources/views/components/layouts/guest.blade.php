<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Inventario Excel' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @livewireStyles

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0f3d7a, #1d4ed8);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            box-sizing: border-box;
        }

        .guest-container {
            width: 100%;
            max-width: 520px;
        }

        .brand {
            text-align: center;
            color: white;
            margin-bottom: 24px;
        }

        .brand h1 {
            margin: 0 0 8px;
            font-size: 32px;
        }

        .brand p {
            margin: 0;
            opacity: .9;
        }

        .guest-card {
            background: white;
            border-radius: 22px;
            padding: 30px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, .22);
        }

        .guest-card h2 {
            margin-top: 0;
            color: #0f3d7a;
        }

        .small {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #1f2937;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 16px;
            box-sizing: border-box;
            margin-bottom: 14px;
        }

        input:focus {
            outline: none;
            border-color: #0f3d7a;
            box-shadow: 0 0 0 4px rgba(15, 61, 122, .12);
        }

        button {
            width: 100%;
            background: #0f3d7a;
            color: white;
            border: none;
            padding: 14px 22px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #0c3264;
        }

        button:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        .message {
            padding: 13px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .warning {
            background: #fef3c7;
            color: #92400e;
        }

        .danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .info {
            background: #dbeafe;
            color: #1e40af;
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

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            font-weight: normal;
            color: #334155;
        }

        .checkbox-row input {
            width: auto;
            margin: 0;
        }

        .guest-footer {
            text-align: center;
            margin-top: 18px;
            color: white;
            font-size: 14px;
        }

        .guest-footer a {
            color: white;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            body {
                padding: 16px;
                align-items: flex-start;
            }

            .brand h1 {
                font-size: 26px;
            }

            .guest-card {
                padding: 22px;
                border-radius: 18px;
            }
        }
    </style>
</head>
<body>

<div class="guest-container">
    <div class="brand">
        <h1>Inventario Excel</h1>
        <p>Sistema de inventario para farmacias</p>
    </div>

    {{ $slot }}

    <div class="guest-footer">
        <span>¿Ya tienes una farmacia registrada?</span>
        <a href="/login">Iniciar sesión</a>
    </div>
</div>

@livewireScripts

</body>
</html>