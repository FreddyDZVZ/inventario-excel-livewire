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
        }

        .topbar a {
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,.15);
            padding: 9px 13px;
            border-radius: 10px;
            font-size: 14px;
        }

        .topbar a:hover {
            background: rgba(255,255,255,.25);
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
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

        input[readonly] {
            background: #f1f5f9;
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

        .small {
            color: #64748b;
            font-size: 13px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .full {
            grid-column: 1 / -1;
        }

        .scanner-box {
            background: #eef5ff;
            padding: 20px;
            border-radius: 14px;
            margin-bottom: 22px;
        }

        .scanner-input {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
            border: 2px solid #93c5fd;
            background: #ffffff;
        }

        .scanner-input:focus {
            outline: none;
            border-color: #0f3d7a;
            box-shadow: 0 0 0 4px rgba(15, 61, 122, .12);
        }

        .box {
            border: 2px dashed #9ab4d6;
            padding: 30px;
            border-radius: 14px;
            text-align: center;
            background: #f8fbff;
        }

        .actions {
            margin-top: 18px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .secondary-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #64748b;
            color: white;
            text-decoration: none;
            padding: 13px 22px;
            border-radius: 10px;
            font-size: 15px;
        }

        .secondary-link:hover {
            background: #475569;
        }

        .download-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #15803d;
            color: white;
            text-decoration: none;
            padding: 13px 22px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
        }

        .download-link:hover {
            background: #166534;
        }

        .product-preview {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 18px;
            border-radius: 14px;
            margin-bottom: 18px;
        }

        .product-preview p {
            margin: 6px 0;
        }

        .products-header {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .products-header h2 {
            margin-top: 0;
        }

        .products-header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .product-toolbar {
            display: grid;
            grid-template-columns: 1fr 160px;
            gap: 16px;
            margin-bottom: 18px;
            align-items: end;
        }

        .product-toolbar select {
            width: 100%;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            background: white;
            box-sizing: border-box;
            margin-bottom: 14px;
        }

        .summary-box {
            background: #eef5ff;
            border: 1px solid #bfdbfe;
            color: #1e3a8a;
            padding: 13px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 900px;
        }

        thead {
            background: #0f3d7a;
            color: white;
        }

        th {
            padding: 13px 12px;
            text-align: left;
            font-size: 13px;
            cursor: pointer;
            white-space: nowrap;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            vertical-align: top;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .badge {
            display: inline-block;
            background: #e0f2fe;
            color: #075985;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending-text {
            color: #b45309;
            font-weight: bold;
        }

        .empty-table {
            text-align: center;
            color: #64748b;
            padding: 28px;
        }

        .pagination-box {
            margin-top: 18px;
        }

        .pagination-box nav {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pagination-box svg {
            width: 18px !important;
            height: 18px !important;
        }

        .pagination-box a,
        .pagination-box span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .pagination-box a {
            background: #0f3d7a;
            color: white;
        }

        .pagination-box a:hover {
            background: #0c3264;
        }

        .pagination-box span {
            background: #e5e7eb;
            color: #374151;
        }

        .pagination-box p {
            width: 100%;
            text-align: center;
            color: #64748b;
            font-size: 13px;
        }

        .dashboard-grid {
            display: grid;
            gap: 20px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #0f3d7a, #1d4ed8);
            color: white;
            padding: 28px;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: center;
            box-shadow: 0 10px 30px rgba(15, 61, 122, .25);
        }

        .welcome-card h2 {
            margin: 0 0 8px;
            font-size: 26px;
        }

        .welcome-card p {
            margin: 0;
            opacity: .9;
            max-width: 620px;
        }

        .main-action {
            background: white;
            color: #0f3d7a;
            padding: 14px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            white-space: nowrap;
        }

        .main-action:hover {
            background: #e0ecff;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 18px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,.05);
        }

        .stat-card span {
            display: block;
            color: #64748b;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .stat-card strong {
            color: #0f3d7a;
            font-size: 28px;
        }

        .warning-stat strong {
            color: #b45309;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .quick-card {
            display: flex;
            gap: 16px;
            align-items: center;
            background: white;
            border: 1px solid #e2e8f0;
            padding: 22px;
            border-radius: 18px;
            text-decoration: none;
            color: #1f2937;
            box-shadow: 0 8px 20px rgba(0,0,0,.05);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .quick-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(0,0,0,.09);
        }

        .quick-card.primary {
            border-color: #bfdbfe;
            background: #eff6ff;
        }

        .quick-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: #eef5ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
        }

        .quick-card h3 {
            margin: 0 0 6px;
            color: #0f3d7a;
        }

        .quick-card p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .products-header {
                flex-direction: column;
            }

            .products-header-actions {
                justify-content: flex-start;
            }
        }

        @media (max-width: 700px) {
            body {
                padding: 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }

            .topbar {
                align-items: flex-start;
            }

            .product-toolbar {
                grid-template-columns: 1fr;
            }

            .welcome-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .main-action {
                width: 100%;
                text-align: center;
                box-sizing: border-box;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .download-link,
            .secondary-link {
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>

<div class="app-container">
    <div class="topbar">
        <h1>Inventario Excel</h1>

        <nav>
            <a href="{{ route('dashboard.index') }}">Inicio</a>
            <a href="{{ route('inventory.upload') }}">Subir Excel</a>
            <a href="{{ route('scanner.index') }}">Escáner rápido</a>
            <a href="{{ route('products.index') }}">Productos</a>
        </nav>
    </div>

    {{ $slot }}
</div>

@livewireScripts

</body>
</html>