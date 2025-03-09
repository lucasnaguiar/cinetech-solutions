<?php

namespace App\Models;

use Core\BaseModel;


class Product extends BaseModel
{
    protected string $table = "products";
    public int $id;
    public string $name;
    public ?string $description = null;
    public string $price;
    public int $stock_quantity;
    public string $created_at;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function setStockQuantity(string $stockQuantity): void
    {
        $this->stock_quantity = $stockQuantity;
    }

}
