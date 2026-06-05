<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductExportController
{
    public function export(): StreamedResponse
    {
        $fileName = 'productos-inventario-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            // BOM para que Excel abra bien acentos y ñ
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'ID',
                'Código',
                'Producto',
                'P. Costo',
                'P. Venta',
                'P. Mayoreo',
                'Departamento',
                'Existencia',
                'Inv. Mínimo',
                'Inv. Máximo',
                'Tipo de Venta',
                'IVA',
                'Origen',
                'Creado',
                'Actualizado',
            ]);

            Product::query()
                ->orderBy('id')
                ->chunk(500, function ($products) use ($handle) {
                    foreach ($products as $product) {
                        fputcsv($handle, [
                            $product->id,
                            $product->barcode,
                            $product->name,
                            $product->cost_price,
                            $product->sale_price,
                            $product->wholesale_price,
                            $product->department,
                            $product->stock,
                            $product->min_stock,
                            $product->max_stock,
                            $product->sale_type,
                            $product->iva,
                            $product->source,
                            optional($product->created_at)->format('Y-m-d H:i:s'),
                            optional($product->updated_at)->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}