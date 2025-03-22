<?php

namespace App\Models;

use Core\BaseModel;


class Movie extends BaseModel
{
    protected string $table = "movies";
    public int $id;
    public string $title;
    public ?string $description = null;
    public int $genre_id;
    public ?string $cover;
    public string $trailer_link;
    public string $release_date;
    public int $duration;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setGenreId(string $genreId): void
    {
        $this->genre_id = $genreId;
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

    public function searchByTitle(string $term): void
    {
        $query = "SELECT * FROM {$this->table} WHERE {$term} LIMIT 100";

        $stmt = $this->db->prepare($query);
        $success = $stmt->execute(['id' => $id]);
    }
}
