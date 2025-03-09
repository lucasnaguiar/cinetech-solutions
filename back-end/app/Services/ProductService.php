<?php

namespace App\Services;

use App\Models\Product;
use Valitron\Validator;

class ProductService
{
    public function store(Product $product)
    {
        $product->create();
    }
}
