<div class="card">
    <div class="products-header">
        <div>
            <h2>Productos importados</h2>

            <p class="small">
                Aquí puedes verificar los productos que se importaron desde tu Excel o que agregaste desde el escáner.
            </p>
        </div>

        <div class="products-header-actions">
            <a href="{{ route('products.export') }}" class="download-link">
                Descargar productos
            </a>

            <a href="{{ route('scanner.index') }}" class="secondary-link">
                Escanear producto
            </a>
        </div>
    </div>

    <div class="product-toolbar">
        <div>
            <label for="search">Buscar producto</label>
            <input
                id="search"
                type="text"
                wire:model.live.debounce.400ms="search"
                placeholder="Buscar por código, producto, departamento u origen..."
            >
        </div>

        <div>
            <label for="perPage">Mostrar</label>
            <select id="perPage" wire:model.live="perPage">
                <option value="10">10 filas</option>
                <option value="15">15 filas</option>
                <option value="25">25 filas</option>
                <option value="50">50 filas</option>
                <option value="100">100 filas</option>
            </select>
        </div>
    </div>

    <div class="summary-box">
        <strong>Total de productos registrados:</strong> {{ $totalProducts }}
    </div>

    <div wire:loading class="message info">
        Cargando productos...
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th wire:click="sortBy('id')">
                        ID
                    </th>
                    <th wire:click="sortBy('barcode')">
                        Código
                    </th>
                    <th wire:click="sortBy('name')">
                        Producto
                    </th>
                    <th wire:click="sortBy('sale_price')">
                        P. Venta
                    </th>
                    <th wire:click="sortBy('stock')">
                        Existencia
                    </th>
                    <th wire:click="sortBy('department')">
                        Departamento
                    </th>
                    <th wire:click="sortBy('source')">
                        Origen
                    </th>
                    <th wire:click="sortBy('created_at')">
                        Creado
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>

                        <td>
                            <strong>{{ $product->barcode }}</strong>
                        </td>

                        <td>{{ $product->name ?: 'Sin descripción' }}</td>

                        <td>
                            @if ($product->sale_price !== null)
                                ${{ number_format((float) $product->sale_price, 2) }}
                            @else
                                <span class="pending-text">Pendiente</span>
                            @endif
                        </td>

                        <td>
                            @if ((float) $product->stock > 0)
                                {{ number_format((float) $product->stock, 0) }}
                            @else
                                <span class="pending-text">Sin existencia</span>
                            @endif
                        </td>

                        <td>{{ $product->department ?: 'Sin departamento' }}</td>

                        <td>
                            <span class="badge">
                                {{ $product->source ?: 'manual' }}
                            </span>
                        </td>

                        <td>
                            {{ $product->created_at?->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-table">
                            No hay productos registrados todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-box">
        {{ $products->onEachSide(1)->links() }}
    </div>
</div>