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

        try {
            $movieModel = new Movie();
            $movieModel->validateGenreIds($requestData['genres']);
            $this->validateRequest($requestData);

            $requestData = (object) $requestData;
            $movie = $this->movieService->store($requestData);
            return json_encode(value: $movie);
        } catch (Exception $e) {
            http_response_code(500);
            return json_encode($e->getMessage());
        }
    }

    public function show($id)
    {
        $movie = (new Movie())->findById($id);
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

    public function updateCover($id)
    {
        $movie = (new Movie())->findById($id);

        if (empty($movie)) {
            return jsonResponse(['message' => 'Filme não encontrado'], 404);
        }

        if (!isset($_FILES['cover'])) {
            return jsonResponse([
                'success' => false,
                'error' => 'Nenhum arquivo enviado'
            ], 422);
        }

        $uploadDir = __DIR__ . '/../../public/storage/covers/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 5MB

        $file = $_FILES['cover'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        if (!in_array($mime, $allowedTypes)) {
            return jsonResponse([
                'success' => false,
                'error' => 'Tipo de arquivo não permitido'
            ], 422);
        }

        if ($file['size'] > $maxSize) {
            return jsonResponse([
                'success' => false,
                'error' => 'Arquivo muito grande (máx. 5MB)'
            ], 422);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = Uuid::uuid4() . '.' . $extension;
        $targetPath = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $error = error_get_last();
                return jsonResponse([
                    'success' => false,
                    'error' => 'Falha ao criar diretório',
                    'details' => $error['message'] ?? 'Erro desconhecido'
                ], 500);
            }
        }

        if (!is_writable($uploadDir)) {
            return jsonResponse([
                'success' => false,
                'error' => 'Diretório sem permissão de escrita',
                'details' => 'Verifique as permissões do diretório: ' . $uploadDir
            ], 500);
        }

        if (!move_uploaded_file($_FILES['cover']['tmp_name'], $targetPath)) {
            $error = error_get_last();
            $errorDetails = [
                'php_error' => $error['message'] ?? 'Erro desconhecido',
                'tmp_name' => $_FILES['cover']['tmp_name'],
                'target_path' => $targetPath,
                'file_size' => $_FILES['cover']['size'],
                'system_permissions' => substr(sprintf('%o', fileperms($uploadDir)), -4)
            ];

            return jsonResponse([
                'success' => false,
                'error' => 'Falha ao mover arquivo',
                'details' => $errorDetails
            ], 500);
        }

        return jsonResponse([
            'success' => true,
            'message' => 'Arquivo salvo com sucesso!',
            'relative_path' => 'public/storage/covers/' . $fileName
        ], 200);
    }
}
