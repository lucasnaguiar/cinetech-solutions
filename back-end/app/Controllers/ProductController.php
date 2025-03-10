<?php

namespace App\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Pecee\SimpleRouter\SimpleRouter;
use Valitron\Validator;

class ProductController
{
    public ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index()
    {
        $products = (new Product())->findAll();

        return json_encode($products);
    }

    public function store()
    {
        $request = SimpleRouter::request();
        $requestData = $request->getInputHandler()->all();

        $v = new Validator($requestData);
        $v->rules([
            'required' => [
                ['name'],
                ['stock_quantity'],
                ['price'],
            ]
        ]);
        $v->rule('lengthMax', 'name', 255);
        $v->rule('integer', 'stock_quantity');

        if (!$v->validate()) {
            http_response_code(422);
            return json_encode($v->errors());
        }

        $requestData = (object) $requestData;
        $product = $this->productService->store($requestData);

        http_response_code(201);
        return json_encode($product);
    }

    public function show($id)
    {
        $product = (new Product())->findById($id);
        if (empty($product)) {
            http_response_code(404);
            return json_encode(['message' => 'Produto não encontrado']);
        }
        return json_encode($product);
    }
    public function update($product)
    {
        $product = (new Product())->findById($product);

        if (empty($product)) {
            http_response_code(404);
            return json_encode(['message' => 'Produto não encontrado']);
        }
        $request = SimpleRouter::request();
        $requestData = $request->getInputHandler()->all();

        $v = new Validator($requestData);
        $v->rules([
            'required' => [
                ['name'],
                ['stock_quantity'],
                ['price'],
            ]
        ]);
        $v->rule('lengthMax', 'name', 255);
        $v->rule('integer', 'stock_quantity');

        if (!$v->validate()) {
            http_response_code(422);
            return json_encode($v->errors());
        }

        $requestData = (object) $requestData;
        $product = $this->productService->update($product, $requestData);

        http_response_code(200);
        return json_encode($product);
    }

    public function validate(array $data) {}
    public function destroy($product)
    {
        $product = (new Product())->findById($product);

        if (empty($product)) {
            http_response_code(response_code: 404);
            return json_encode(['message' => 'Produto não encontrado']);
        }

        if (!$product->delete()) {
            http_response_code(response_code: 400);
            return json_encode(['message' => 'A exclusão falhou.']);
        }

        http_response_code(response_code: 204);
    }
}
