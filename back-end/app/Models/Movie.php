<?php

namespace App\Models;

use Core\BaseModel;
use Core\Database;
use Exception;
use PDO;

class Movie extends BaseModel
{
    protected string $table = "movies";
    public int $id;
    public string $title;
    public string $slug;
    public ?array $genres;

    public ?string $description = null;
    public ?string $cover;
    public string $trailer_link;
    public string $release_date;
    public int $duration;

    public function setTitle(string $title): void
    {
        $this->title = $title;
        $this->slug = slugify($this->title);
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setGenres(array $genres): void
    {
        $this->genres = $genres;
    }

    public function setReleaseDate(string $releaseDate): void
    {
        $this->release_date = $releaseDate;
    }

    public function setTrailerLink(string $trailerLink): void
    {
        $this->trailer_link = $trailerLink;
    }

    public function setCover(string $cover): void
    {
        $this->cover = $cover;
    }

    public function setDuration(string $duration): void
    {
        $this->duration = $duration;
    }

    public function getGenres(): array
    {
        if (!isset($this->id)) {
            throw new Exception('O filme precisa ter um ID para buscar os gêneros.');
        }

        $query = "
            SELECT mg.*
            FROM movie_genres mg
            INNER JOIN movie_genre_movie mgm ON mg.id = mgm.genre_id
            WHERE mgm.movie_id = :movie_id
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['movie_id' => $this->id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveMovieGenres(array $genreIds): void
    {
        if (!isset($this->id)) {
            throw new Exception('O filme precisa ter um ID para salvar os gêneros.');
        }

        // Primeiro remove associações existentes
        $this->db->beginTransaction();
        try {
            $deleteQuery = "DELETE FROM movie_genre_movie WHERE movie_id = :movie_id";
            $deleteStmt = $this->db->prepare($deleteQuery);
            $deleteStmt->execute(['movie_id' => $this->id]);

            // Insere as novas associações
            $insertQuery = "INSERT INTO movie_genre_movie (movie_id, genre_id) VALUES (:movie_id, :genre_id)";
            $insertStmt = $this->db->prepare($insertQuery);

            foreach ($genreIds as $genreId) {
                $insertStmt->execute([
                    'movie_id' => $this->id,
                    'genre_id' => $genreId
                ]);
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public static function getMoviesByGenre(int $genreId): array
    {
        $query = "
            SELECT m.*
            FROM movies m
            INNER JOIN movie_genre_movie mgm ON m.id = mgm.movie_id
            WHERE mgm.genre_id = :genre_id
        ";

        $db = Database::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute(['genre_id' => $genreId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validateGenreIds(array $genreIds): void
    {
        $this->validateIdsExist($genreIds, 'movie_genres');
    }

    public function buildQuery(array $filters = []): \PDOStatement
    {
        $query = "SELECT m.* FROM movies m";
        $params = [];
        $conditions = [];

        if (!empty($filters['genre'])) {
            $query .= " JOIN movie_genre_movie mgm ON m.id = mgm.movie_id";
            $conditions[] = "mgm.genre_id = :genre_id";
            $params[':genre_id'] = $filters['genre'];
        }

        if (!empty($filters['search'])) {
            $conditions[] = "m.title LIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $query .= " ORDER BY m.title ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }

    public function updateCover($movie, $cover): void {}
}
