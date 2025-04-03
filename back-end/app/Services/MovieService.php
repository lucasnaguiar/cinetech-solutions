<?php

namespace App\Services;

use App\Models\Movie;
use Exception;
use finfo;
use Ramsey\Uuid\Uuid;

class MovieService
{
    public const UPLOAD_DIR = __DIR__ . '/../../public/storage/covers/';
    public function store($requestData): Movie
    {
        $movie = new Movie();
        $movie->setTitle($requestData->title);
        $movie->setDescription($requestData->description);
        $movie->setReleaseDate($requestData->release_date);
        $movie->setTrailerLink($requestData->trailer_link);
        $movie->setCover($this->uploadCover($movie, $requestData->cover));
        $movie->setDuration($requestData->duration);

        $movie = $movie->save();

        $movie->saveMovieGenres($requestData->genres);

        $movie->genres = $movie->getGenres();

        return $movie;
    }

    public function update($movie, $requestData): Movie
    {

        $coverPath = isset($requestData->cover) ? $this->uploadCover($requestData->cover) : $movie->cover;

        $movie->setTitle($requestData->title);
        $movie->setDescription($requestData->description);
        $movie->setGenreId($requestData->genre_id);
        $movie->setReleaseDate($requestData->release_date);
        $movie->setTrailerLink($requestData->trailer_link);
        $movie->setCover($coverPath);
        $movie->setDuration($requestData->duration);
        $movie->update();

        return $movie;
    }

    public function validateFile($file)
    {
        $allowedTypes = ['image/jpeg', 'image/png','image/jpg', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception(json_encode([
                'success' => false,
                'error' => 'Tipo de arquivo não permitido'
            ], 422));
        }

        if ($file['size'] > $maxSize) {
            throw new Exception(json_encode([
                'success' => false,
                'error' => 'Arquivo muito grande (máx. 5MB)'
            ]), 422);
        }

        if (!is_dir(self::UPLOAD_DIR)) {
            if (!mkdir(self::UPLOAD_DIR, 0755, true)) {
                $error = error_get_last();
                throw new Exception(json_encode([
                    'success' => false,
                    'error' => 'Falha ao criar diretório',
                    'details' => $error['message'] ?? 'Erro desconhecido'
                ]), 422);
            }
        }

        if (!is_writable(self::UPLOAD_DIR)) {
            throw new Exception(json_encode([
                'success' => false,
                'error' => 'Diretório sem permissão de escrita',
                'details' => 'Verifique as permissões do diretório: ' . self::UPLOAD_DIR
            ]), 422);
        }

    }

    public function updateCover($movie, $requestData): Movie
    {
        $coverPath = isset($requestData->cover) ? $this->uploadCover($requestData->cover) : $movie->cover;
        $movie->cover = $coverPath;
        $movie->update();
        return $movie;
    }

    public function uploadCover($file): string
    {
        $file = $_FILES['cover'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = Uuid::uuid4() . '.' . $extension;
        $targetPath = self::UPLOAD_DIR . $fileName;
        
        try {
            $this->validateFile($file);
            
            if (!move_uploaded_file($_FILES['cover']['tmp_name'], $targetPath)) {
                $error = error_get_last();
                $errorDetails = [
                    'php_error' => $error['message'] ?? 'Erro desconhecido',
                    'tmp_name' => $_FILES['cover']['tmp_name'],
                    'target_path' => $targetPath,
                    'file_size' => $_FILES['cover']['size'],
                    'system_permissions' => substr(sprintf('%o', fileperms(self::UPLOAD_DIR)), -4)
                ];
                throw new Exception(json_encode($errorDetails));
            }

            return 'storage/covers/' . $fileName;
        } catch (Exception $e) {
            return json_encode($e->getMessage());
        }
    }
}
