<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class DashboardSummary extends Component
{
    public function render()
    {
        return view('livewire.dashboard-summary', [
            'totalProducts' => Product::count(),
            'productsWithoutPrice' => Product::whereNull('sale_price')->orWhere('sale_price', 0)->count(),
            'productsWithoutStock' => Product::whereNull('stock')->orWhere('stock', 0)->count(),
            'manualProducts' => Product::where('source', 'manual')->count(),
            'internetProducts' => Product::whereIn('source', ['open_food_facts', 'upcitemdb', 'internet'])->count(),
        ]);
    }
}