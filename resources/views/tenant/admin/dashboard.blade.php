<x-layouts.tenant title="Panel administrador">
    <div class="dashboard-grid">
        <section class="hero-card">
            <div>
                <span class="eyebrow">Sistema activo</span>
                <h1>Bienvenido a tu farmacia inteligente</h1>
                <p>
                    Controla ventas, inventario, caja y productos desde un solo panel.
                    Este será el centro de operación de tu punto de venta.
                </p>
            </div>

            <a href="{{ route('tenant.pos') }}" class="hero-button">
                Iniciar venta
            </a>
        </section>

        <section class="stats-grid">
            <div class="stat-card">
                <span>Ventas de hoy</span>
                <strong>$0.00</strong>
                <small>Listo para conectar al POS</small>
            </div>

            <div class="stat-card">
                <span>Productos</span>
                <strong>0</strong>
                <small>Catálogo de farmacia</small>
            </div>

            <div class="stat-card warning">
                <span>Stock bajo</span>
                <strong>0</strong>
                <small>Alertas próximas</small>
            </div>

            <div class="stat-card success">
                <span>Caja actual</span>
                <strong>Abierta</strong>
                <small>Control de turno</small>
            </div>
        </section>

        <section class="module-grid">
            <a href="{{ route('tenant.pos') }}" class="module-card featured">
                <div class="module-icon">🧾</div>
                <div>
                    <h3>Punto de venta</h3>
                    <p>Vende rápido con lector de código de barras, búsqueda inteligente y carrito.</p>
                </div>
            </a>

            <a href="{{ route('tenant.products') }}" class="module-card">
                <div class="module-icon">💊</div>
                <div>
                    <h3>Productos</h3>
                    <p>Catálogo de medicamentos, precios, existencia e información comercial.</p>
                </div>
            </a>

            <a href="{{ route('tenant.inventory') }}" class="module-card">
                <div class="module-icon">📦</div>
                <div>
                    <h3>Inventario</h3>
                    <p>Entradas, ajustes, importaciones y control de stock por farmacia.</p>
                </div>
            </a>

            <a href="{{ route('tenant.sales') }}" class="module-card">
                <div class="module-icon">📈</div>
                <div>
                    <h3>Ventas</h3>
                    <p>Consulta tickets, ventas del día, cortes y movimientos recientes.</p>
                </div>
            </a>

            <a href="{{ route('tenant.cash') }}" class="module-card">
                <div class="module-icon">💵</div>
                <div>
                    <h3>Caja</h3>
                    <p>Apertura, cierre, retiros, ingresos y control por usuario.</p>
                </div>
            </a>

            <a href="{{ route('tenant.reports') }}" class="module-card">
                <div class="module-icon">📊</div>
                <div>
                    <h3>Reportes</h3>
                    <p>Ventas, productos más vendidos, utilidad, inventario y alertas.</p>
                </div>
            </a>
        </section>

        <section class="card">
            <h2>Próximas funciones innovadoras</h2>

            <div class="innovation-list">
                <div>
                    <strong>Escáner inteligente</strong>
                    <span>Detectar producto, precio y existencia desde código de barras.</span>
                </div>

                <div>
                    <strong>Alertas de inventario</strong>
                    <span>Productos agotados, próximos a terminarse o sin precio.</span>
                </div>

                <div>
                    <strong>Venta rápida</strong>
                    <span>Interfaz optimizada para mostrador, teclado y lector físico.</span>
                </div>

                <div>
                    <strong>Panel por farmacia</strong>
                    <span>Cada cliente trabaja en su propia base de datos independiente.</span>
                </div>
            </div>
        </section>
    </div>

    <style>
        .dashboard-grid {
            display: grid;
            gap: 22px;
        }

        .hero-card {
            background: linear-gradient(135deg, #0f3d7a, #1d4ed8);
            color: white;
            border-radius: 24px;
            padding: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            box-shadow: 0 18px 40px rgba(15, 61, 122, .24);
        }

        .hero-card h1 {
            margin: 8px 0 10px;
            font-size: 30px;
        }

        .hero-card p {
            margin: 0;
            max-width: 620px;
            opacity: .9;
            line-height: 1.5;
        }

        .eyebrow {
            background: rgba(255,255,255,.18);
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .hero-button {
            background: white;
            color: #0f3d7a;
            padding: 14px 20px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: bold;
            white-space: nowrap;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(15, 61, 122, .06);
        }

        .stat-card span {
            display: block;
            color: #64748b;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .stat-card strong {
            display: block;
            color: #0f3d7a;
            font-size: 26px;
            margin-bottom: 6px;
        }

        .stat-card small {
            color: #64748b;
        }

        .stat-card.warning strong {
            color: #b45309;
        }

        .stat-card.success strong {
            color: #15803d;
        }

        .module-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .module-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 22px;
            padding: 22px;
            display: flex;
            gap: 16px;
            text-decoration: none;
            color: #1f2937;
            box-shadow: 0 8px 24px rgba(15, 61, 122, .06);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .module-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(15, 61, 122, .12);
        }

        .module-card.featured {
            border-color: #bfdbfe;
            background: #eff6ff;
        }

        .module-icon {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            background: #eef5ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .module-card h3 {
            margin: 0 0 8px;
            color: #0f3d7a;
        }

        .module-card p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.45;
        }

        .innovation-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 16px;
        }

        .innovation-list div {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 16px;
            border-radius: 16px;
        }

        .innovation-list strong {
            display: block;
            color: #0f3d7a;
            margin-bottom: 5px;
        }

        .innovation-list span {
            color: #64748b;
            font-size: 14px;
            line-height: 1.4;
        }

        @media (max-width: 1000px) {
            .stats-grid,
            .module-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .hero-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-button {
                width: 100%;
                text-align: center;
            }

            .stats-grid,
            .module-grid,
            .innovation-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-layouts.tenant>