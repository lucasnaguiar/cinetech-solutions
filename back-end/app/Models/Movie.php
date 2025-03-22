<?php

namespace App\Models;

use Core\BaseModel;


class Movie extends BaseModel
{
    protected string $table = "movies";
    public int $id;
    public string $title;
    public string $slug;
    public ?string $description = null;
    public int $genre_id;
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
}
