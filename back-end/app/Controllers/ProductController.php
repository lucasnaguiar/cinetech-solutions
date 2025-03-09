<?php

namespace App\Controllers;

use App\Models\Product;
use Pecee\SimpleRouter\SimpleRouter;
use Valitron\Validator;

class ProductController
{
    public function index()
    {
        //
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
    }

    public function show($id)
    {
        //
    }
}
