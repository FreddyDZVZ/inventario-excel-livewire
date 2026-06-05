<?php

namespace App\Services;

use App\Models\Product;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelInventoryImportService
{
    public function import(string $filePath): int
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $imported = 0;

        for ($row = 2; $row <= $highestRow; $row++) {
            $barcode = $this->cleanBarcode($sheet->getCell("A{$row}")->getValue());

            if (! $barcode) {
                continue;
            }

            $data = [
                'name' => $this->cleanText($sheet->getCell("B{$row}")->getValue()),
                'cost_price' => $this->money($sheet->getCell("C{$row}")->getValue()),
                'sale_price' => $this->money($sheet->getCell("D{$row}")->getValue()),
                'wholesale_price' => $this->money($sheet->getCell("E{$row}")->getValue()),
                'department' => $this->cleanText($sheet->getCell("F{$row}")->getValue()),
                'stock' => $this->number($sheet->getCell("G{$row}")->getValue()) ?? 0,
                'min_stock' => $this->number($sheet->getCell("H{$row}")->getValue()),
                'max_stock' => $this->number($sheet->getCell("I{$row}")->getValue()),
                'sale_type' => $this->cleanText($sheet->getCell("J{$row}")->getValue()),
                'iva' => $this->number($sheet->getCell("K{$row}")->getValue()),
                'source' => 'excel',
            ];

            $product = Product::where('barcode', $barcode)->first();

            if ($product) {
                $product->update([
                    'name' => $product->name ?: $data['name'],
                    'cost_price' => $product->cost_price ?: $data['cost_price'],
                    'sale_price' => $product->sale_price ?: $data['sale_price'],
                    'wholesale_price' => $product->wholesale_price ?: $data['wholesale_price'],
                    'department' => $product->department ?: $data['department'],
                    'stock' => ((float) $product->stock) + ((float) $data['stock']),
                    'min_stock' => $product->min_stock ?: $data['min_stock'],
                    'max_stock' => $product->max_stock ?: $data['max_stock'],
                    'sale_type' => $product->sale_type ?: $data['sale_type'],
                    'iva' => $product->iva ?: $data['iva'],
                    'source' => 'excel',
                ]);
            } else {
                Product::create([
                    'barcode' => $barcode,
                    ...$data,
                ]);
            }

            $imported++;
        }

        return $imported;
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

    private function cleanText($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value !== '' ? $value : null;
    }

    private function money($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = str_replace(['$', ',', ' '], '', (string) $value);

        return is_numeric($value) ? (float) $value : null;
    }

    private function number($value): ?float
    {
        if ($value === null || $value === '' || $value === '-') {
            return null;
        }

        $value = str_replace([',', ' '], '', (string) $value);

        return is_numeric($value) ? (float) $value : null;
    }
}
