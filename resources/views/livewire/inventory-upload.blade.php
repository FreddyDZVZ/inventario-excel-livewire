<div class="card">
    <h2>Subir inventario desde Excel</h2>

    <p class="small">
        Sube tu archivo Excel. El sistema importará los productos y después podrás escanear códigos de barras.
    </p>

    @if ($message)
        <div class="message {{ $messageType }}">
            {{ $message }}
        </div>
    @endif

    @error('excelFile')
        <div class="message danger">
            {{ $message }}
        </div>
    @enderror

    <form wire:submit.prevent="import">
        <div class="box">
            <p>Selecciona tu archivo de inventario.</p>

            <input type="file" wire:model="excelFile" accept=".xlsx,.xls,.csv">

            <div wire:loading wire:target="excelFile" class="message info">
                Cargando archivo...
            </div>

            <div wire:loading wire:target="import" class="message info">
                Importando inventario, no cierres esta pantalla...
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="import">
                Importar inventario
            </button>
        </div>
    </form>
</div>
