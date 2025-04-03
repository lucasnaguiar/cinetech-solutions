<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;

use Exception;
use App\Models\Movie;
use App\Services\MovieService;
use finfo;
use Pecee\SimpleRouter\SimpleRouter;
use Valitron\Validator;

class MovieController
{
    public MovieService $movieService;

    public function __construct()
    {
        $this->movieService = new MovieService();
    }

    public function index()
    {
        $request = SimpleRouter::request();
        $requestData = $request->getInputHandler()->all();

        $filters = [];

        if (!empty($requestData['search'])) {
            $filters['search'] = trim($requestData['search']);
        }

        if (!empty($requestData['genre'])) {
            $filters['genre'] = (int)$requestData['genre'];
        }

        try {
            $stmt = (new Movie())->buildQuery($filters);
            $movies = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return json_encode($movies);
        } catch (\Exception $e) {
            http_response_code(500);
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function store()
    {
        $request = SimpleRouter::request();
        $requestData = $request->getInputHandler()->all();
        $requestData['genres'] = explode(',', $requestData['genres'][0]);
        $movieModel = new Movie();
        $movieModel->validateGenreIds($requestData['genres']);
        $this->validateRequest($requestData);

        $requestData = (object) $requestData;
        $movie = $this->movieService->store($requestData);
        return json_encode(value: $movie);
    }

    public function show($id)
    {
        $movie = (new Movie())->findById($id);
        $movie->genres = $movie->getGenres();
        if (empty($movie)) {
            http_response_code(404);
            return json_encode(['message' => 'Filme não encontrado']);
        }
        return json_encode($movie);
    }

    public function update($id)
    {
        $movie = (new Movie())->findById($id);

        if (empty($movie)) {
            http_response_code(404);
            return json_encode(['message' => 'Filme não encontrado']);
        }

        $request = SimpleRouter::request();
        $requestData = $request->getInputHandler()->all();

        try {
            $movie->validateGenreIds($requestData['genres']);
            $this->validateRequest($requestData);
            $requestData = (object) $requestData;
            $movie = $this->movieService->update($movie, $requestData);
            return json_encode(value: $movie);
        } catch (Exception $e) {
            http_response_code($e->getCode());
            return json_encode($e->getMessage());
        }
    }

    public function updateCover($id)
    {
        $movie = (new Movie())->findById($id);

        if (empty($movie)) {
            http_response_code(404);
            return json_encode(['message' => 'Filme não encontrado']);
        }

        $request = SimpleRouter::request();
        $requestData = $request->getInputHandler()->all();
       
        if (empty($requestData['cover'])) {
            return jsonResponse(['message' => 'É obrigatório enviar o arquivo de imagem.'], 422);
        }

        try {
            $requestData = (object) $requestData;
            $movie = $this->movieService->updateCover($movie, $requestData);
            return jsonResponse($movie, 200);
        } catch (Exception $e) {
            return jsonResponse($e->getMessage(), 500);
        }
    }

    private function validateRequest(array $requestData): void
    {
        $v = new Validator($requestData);
        $v->rule('required', ['title', 'genres', 'release_date', 'duration']);
        $v->rule('lengthMax', 'title', 255);
        $v->rule('lengthMax', 'description', 255);
        $v->rule('lengthMax', 'trailer_link', 255);

        if (!$v->validate()) {
            throw new Exception(json_encode($v->errors()), 422);
        }
    }

    public function destroy($id)
    {
        $movie = (new Movie())->findById($id);

        if (empty($movie)) {
            http_response_code(response_code: 404);
            return json_encode(['message' => 'Filme não encontrado']);
        }

        if (!$movie->delete()) {
            http_response_code(response_code: 500);
            return json_encode(['message' => 'A exclusão falhou.']);
        }

        http_response_code(response_code: 204);
    }
}
