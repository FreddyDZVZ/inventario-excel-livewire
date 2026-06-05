<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\BarcodeLookupService;
use Livewire\Component;

class Scanner extends Component
{
    public string $barcodeInput = '';

    public ?string $barcode = null;

    public ?string $name = null;

    public $sale_price = null;

    public $stock = null;

    public string $source = 'manual';

    public bool $showForm = false;

    public ?string $message = null;

    public string $messageType = 'info';

    public ?array $currentProduct = null;

    public function mount(): void
    {
        if (session()->has('success')) {
            $this->message = session('success');
            $this->messageType = 'success';
        }
    }

    public function searchProduct(BarcodeLookupService $barcodeLookupService): void
    {
        $this->resetProductForm();

        $cleanBarcode = $this->cleanBarcode($this->barcodeInput);

        if (! $cleanBarcode) {
            $this->messageType = 'danger';
            $this->message = 'Escanea o escribe un código de barras válido.';
            return;
        }

        $product = Product::where('barcode', $cleanBarcode)->first();

        if ($product) {
            $this->barcode = $product->barcode;
            $this->name = $product->name;
            $this->sale_price = $product->sale_price;
            $this->stock = $product->stock;
            $this->source = $product->source ?? 'inventory';
            $this->showForm = true;

            $this->currentProduct = [
                'barcode' => $product->barcode,
                'name' => $product->name,
                'sale_price' => $product->sale_price,
                'stock' => $product->stock,
                'source' => $product->source,
            ];

            $this->messageType = 'success';
            $this->message = 'Producto encontrado en tu inventario. Puedes revisar o actualizar los datos.';
            $this->barcodeInput = '';

            return;
        }

        $onlineProduct = $barcodeLookupService->search($cleanBarcode);

        if ($onlineProduct) {
            $this->barcode = $cleanBarcode;
            $this->name = $onlineProduct['name'];
            $this->sale_price = null;
            $this->stock = null;
            $this->source = $onlineProduct['source'] ?? 'internet';
            $this->showForm = true;

            $this->currentProduct = [
                'barcode' => $cleanBarcode,
                'name' => $onlineProduct['name'],
                'sale_price' => null,
                'stock' => null,
                'source' => $this->source,
            ];

            $this->messageType = 'warning';
            $this->message = 'No estaba en tu inventario, pero encontré una descripción en internet. Completa precio y existencia.';
            $this->barcodeInput = '';

            return;
        }

        $this->barcode = $cleanBarcode;
        $this->name = '';
        $this->sale_price = null;
        $this->stock = null;
        $this->source = 'manual';
        $this->showForm = true;

        $this->currentProduct = [
            'barcode' => $cleanBarcode,
            'name' => '',
            'sale_price' => null,
            'stock' => null,
            'source' => 'manual',
        ];

        $this->messageType = 'warning';
        $this->message = 'No se encontró en inventario ni en internet. Captura la descripción, precio y existencia.';
        $this->barcodeInput = '';
    }

    public function saveProduct(): void
    {
        $validated = $this->validate([
            'barcode' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['nullable', 'numeric', 'min:0'],
            'source' => ['nullable', 'string', 'max:50'],
        ], [
            'barcode.required' => 'El código de barras es obligatorio.',
            'name.required' => 'La descripción del producto es obligatoria.',
            'sale_price.numeric' => 'El precio venta debe ser un número.',
            'stock.numeric' => 'La existencia debe ser un número.',
        ]);

        $cleanBarcode = $this->cleanBarcode($validated['barcode']);
        $product = Product::where('barcode', $cleanBarcode)->first();

        if ($product) {
            $product->update([
                'name' => $validated['name'],
                'sale_price' => $validated['sale_price'] ?? null,
                'stock' => $validated['stock'] ?? 0,
                'source' => $validated['source'] ?? $product->source,
            ]);

            $this->messageType = 'success';
            $this->message = 'Producto actualizado correctamente.';
        } else {
            Product::create([
                'barcode' => $cleanBarcode,
                'name' => $validated['name'],
                'sale_price' => $validated['sale_price'] ?? null,
                'stock' => $validated['stock'] ?? 0,
                'source' => $validated['source'] ?? 'manual',
            ]);

            $this->messageType = 'success';
            $this->message = 'Producto agregado correctamente al inventario.';
        }

        $this->resetProductForm();
        $this->barcodeInput = '';
    }

    public function cancelForm(): void
    {
        $this->resetProductForm();
        $this->messageType = 'info';
        $this->message = 'Captura cancelada.';
    }

    private function resetProductForm(): void
    {
        $this->barcode = null;
        $this->name = null;
        $this->sale_price = null;
        $this->stock = null;
        $this->source = 'manual';
        $this->showForm = false;
        $this->currentProduct = null;
    }

    private function cleanBarcode($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        $value = preg_replace('/[^0-9]/', '', $value);

        return $value !== '' ? $value : null;
    }

    public function render()
    {
        return view('livewire.scanner');
    }
}
