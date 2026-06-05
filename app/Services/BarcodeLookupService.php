<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BarcodeLookupService
{
    public function search(string $barcode): ?array
    {
        return $this->searchOpenFoodFacts($barcode)
            ?? $this->searchUpcItemDb($barcode);
    }

    private function searchOpenFoodFacts(string $barcode): ?array
    {
        try {
            $response = Http::timeout(8)->get("https://world.openfoodfacts.org/api/v0/product/{$barcode}.json");

            if (! $response->ok()) {
                return null;
            }

            $data = $response->json();

            if (($data['status'] ?? 0) !== 1) {
                return null;
            }

            $product = $data['product'] ?? [];

            $name = $product['product_name_es']
                ?? $product['product_name']
                ?? $product['generic_name_es']
                ?? $product['generic_name']
                ?? null;

            if (! $name) {
                return null;
            }

            return [
                'barcode' => $barcode,
                'name' => $name,
                'source' => 'open_food_facts',
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function searchUpcItemDb(string $barcode): ?array
    {
        try {
            $response = Http::timeout(8)->get('https://api.upcitemdb.com/prod/trial/lookup', [
                'upc' => $barcode,
            ]);

            if (! $response->ok()) {
                return null;
            }

            $data = $response->json();

            if (($data['code'] ?? '') !== 'OK') {
                return null;
            }

            $item = $data['items'][0] ?? null;

            if (! $item) {
                return null;
            }

            $name = $item['title'] ?? null;

            if (! $name) {
                return null;
            }

            return [
                'barcode' => $barcode,
                'name' => $name,
                'source' => 'upcitemdb',
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }
}
