<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function store($requestData): Product
    {
        $product = new Product();
        $product->name = $requestData->name;
        $product->description = $requestData->description;
        $product->stock_quantity = $requestData->stock_quantity;
        $product->price = $requestData->price;
        $product->created_at = date('Y-m-d H:i:s');

        $product->save();

        return $product;
    }
}
