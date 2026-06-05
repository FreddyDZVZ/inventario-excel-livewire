<?php

namespace App\Livewire;

use App\Services\ExcelInventoryImportService;
use Livewire\Component;
use Livewire\WithFileUploads;

class InventoryUpload extends Component
{
    use WithFileUploads;

    public $excelFile;

    public ?string $message = null;

    public string $messageType = 'info';

    public function import(ExcelInventoryImportService $excelInventoryImportService)
    {
        $this->validate([
            'excelFile' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ], [
            'excelFile.required' => 'Selecciona un archivo Excel.',
            'excelFile.file' => 'El archivo no es válido.',
            'excelFile.mimes' => 'El archivo debe ser xlsx, xls o csv.',
        ]);

        try {
            $path = $this->excelFile->store('imports');

            $fullPath = storage_path('app/private/'.$path);

            if (! file_exists($fullPath)) {
                $fullPath = storage_path('app/'.$path);
            }

            $imported = $excelInventoryImportService->import($fullPath);

            $this->reset('excelFile');

            session()->flash('success', "Inventario importado correctamente. Productos procesados: {$imported}");

            return redirect()->route('scanner.index');
        } catch (\Throwable $e) {
            $this->messageType = 'danger';
            $this->message = 'No se pudo importar el archivo: '.$e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.inventory-upload');
    }
}
