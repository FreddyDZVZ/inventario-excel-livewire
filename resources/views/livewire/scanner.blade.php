<div class="card">
    <h2>Escáner rápido de inventario</h2>

    <p class="small">
        Escanea el código de barras. Si existe en tu inventario, se mostrará.
        Si no existe, intentará buscar la descripción en internet.
    </p>

    @if ($message)
        <div class="message {{ $messageType }}">
            {{ $message }}
        </div>
    @endif

    <div class="scanner-box">
        <label for="barcodeInput">Escanea o escribe el código de barras</label>

        <input
            type="text"
            id="barcodeInput"
            wire:model.defer="barcodeInput"
            wire:keydown.enter.prevent="searchProduct"
            placeholder="Escanea aquí y presiona Enter..."
            autocomplete="off"
            autofocus
            class="scanner-input"
        >

        <div class="actions">
            <button type="button" wire:click="searchProduct" wire:loading.attr="disabled" wire:target="searchProduct">
                Buscar producto
            </button>

            <a href="{{ route('products.index') }}" class="secondary-link">
                Ver productos
            </a>
        </div>

        <div wire:loading wire:target="searchProduct" class="message info" style="margin-top: 14px;">
            Buscando producto...
        </div>

        <p class="small">
            Tip: el lector normalmente escribe el código y presiona Enter automáticamente.
        </p>
    </div>

    @if ($currentProduct)
        <div class="product-preview">
            <p><strong>Código:</strong> {{ $currentProduct['barcode'] }}</p>
            <p><strong>Producto:</strong> {{ $currentProduct['name'] ?: 'Sin descripción todavía' }}</p>
            <p>
                <strong>Precio venta:</strong>
                @if ($currentProduct['sale_price'] !== null)
                    ${{ number_format((float) $currentProduct['sale_price'], 2) }}
                @else
                    Pendiente
                @endif
            </p>
            <p><strong>Existencia:</strong> {{ $currentProduct['stock'] ?? 'Pendiente' }}</p>
            <p><strong>Origen:</strong> {{ $currentProduct['source'] ?? 'manual' }}</p>
        </div>
    @endif

    @if ($showForm)
        <form wire:submit.prevent="saveProduct">
            <input type="hidden" wire:model="source">

            <div class="form-grid">
                <div>
                    <label for="barcode">Código de barras</label>
                    <input
                        type="text"
                        id="barcode"
                        wire:model="barcode"
                        readonly
                    >

                    @error('barcode')
                        <div class="message danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label for="sale_price">Precio venta</label>
                    <input
                        type="number"
                        id="sale_price"
                        wire:model="sale_price"
                        step="0.01"
                        min="0"
                        placeholder="Ej. 120.00"
                    >

                    @error('sale_price')
                        <div class="message danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="full">
                    <label for="name">Descripción / producto</label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        placeholder="Ej. Dexametasona 8 mg"
                    >

                    @error('name')
                        <div class="message danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label for="stock">Existencia</label>
                    <input
                        type="number"
                        id="stock"
                        wire:model="stock"
                        step="1"
                        min="0"
                        placeholder="Ej. 10"
                    >

                    @error('stock')
                        <div class="message danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" wire:loading.attr="disabled" wire:target="saveProduct">
                    Guardar y seguir escaneando
                </button>

                <button type="button" wire:click="cancelForm" style="background:#64748b;">
                    Cancelar
                </button>
            </div>

            <div wire:loading wire:target="saveProduct" class="message info" style="margin-top: 14px;">
                Guardando producto...
            </div>
        </form>
    @endif

    <script>
        document.addEventListener('livewire:init', function () {
            focusScannerInput();

            Livewire.hook('morph.updated', () => {
                focusScannerInput();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            focusScannerInput();
        });

        function focusScannerInput() {
            const input = document.getElementById('barcodeInput');

            if (input) {
                setTimeout(() => {
                    input.focus();
                }, 150);
            }
        }
    </script>
</div>