<?php

use App\Http\Controllers\ProductExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::view('/inicio', 'dashboard.index')
    ->name('dashboard.index');

Route::view('/inventario/subir', 'inventory.upload')
    ->name('inventory.upload');

Route::view('/scanner', 'scanner.index')
    ->name('scanner.index');

Route::view('/productos', 'products.index')
    ->name('products.index');

Route::get('/productos/descargar', [ProductExportController::class, 'export'])
    ->name('products.export');