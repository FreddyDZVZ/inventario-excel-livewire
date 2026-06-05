<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'barcode',
        'name',
        'cost_price',
        'sale_price',
        'wholesale_price',
        'department',
        'stock',
        'min_stock',
        'max_stock',
        'sale_type',
        'iva',
        'source',
    ];
}
