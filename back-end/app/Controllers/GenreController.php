<?php

namespace App\Controllers;

use App\Models\Genre;
use App\Services\GenreService;
use Exception;
use Pecee\SimpleRouter\SimpleRouter;
use Valitron\Validator;

class GenreController
{
    public GenreService $genreService;

    public function __construct()
    {
        $this->genreService = new GenreService();
    }

    public function index()
    {
        $movieGenres = (new Genre())->findAll();

        return json_encode($movieGenres);
    }

    public function store()
    {
        $request = SimpleRouter::request();
        $requestData = $request->getInputHandler()->all();

        try {
            $this->validateRequest($requestData);

            $requestData = (object) $requestData;
            $genre = $this->genreService->store($requestData);
            return json_encode(value: $genre);
        } catch (Exception $e) {
            http_response_code($e->getCode());
            return json_encode($e->getMessage());
        }
    }

    public function show($id)
    {
        $genre = (new Genre())->findById($id);
        if (empty($genre)) {
            http_response_code(404);
            return json_encode(['message' => 'Genero não encontrado']);
        }
        return json_encode($genre);
    }
    public function update($genre)
    {
        $genre = (new Genre())->findById($genre);

        if (empty($genre)) {
            http_response_code(404);
            return json_encode(['message' => 'Genero não encontrado']);
        }
        $request = SimpleRouter::request();
        $requestData = $request->getInputHandler()->all();

        try {
            $this->validateRequest($requestData);
            $requestData = (object) $requestData;
            $genre = $this->genreService->update($genre, $requestData);
            return json_encode(value: $genre);
        } catch (Exception $e) {
            http_response_code($e->getCode());
            return json_encode($e->getMessage());
        }
    }

    function validateRequest(array $requestData): void
    {
        $v = new Validator($requestData);
        $v->rules([
            'required' => [
                ['name'],
            ]
        ]);
        $v->rule('lengthMax', 'name', 255);
        $v->rule('lengthMax', 'description', 255);

        if (!$v->validate()) {
            throw new Exception(json_encode($v->errors()), 422);
        }
    }
    public function destroy($genre)
    {
        $genre = (new Genre())->findById($genre);

        if (empty($genre)) {
            http_response_code(response_code: 404);
            return json_encode(['message' => 'Produto não encontrado']);
        }

        if (!$genre->delete()) {
            http_response_code(response_code: 500);
            return json_encode(['message' => 'A exclusão falhou.']);
        }

        http_response_code(response_code: 204);
    }
}
