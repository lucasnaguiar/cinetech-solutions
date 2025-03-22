<?php

namespace App\Services;

use App\Models\Movie;

class MovieService
{
    public function store($requestData): Genre
    {
        $movie = new Movie();
        $movie->setTitle($requestData->title);
        $movie->setDescription($requestData->description);
        $movie->setGenreId($requestData->genre_id);
        $movie->setReleaseDate($requestData->release_date);
        $movie->setTrailerLink($requestData->trailer_link);
        $movie->setCover($requestData->cover);
        $movie->setDuration($requestData->duration);

        $movie->save();

        return $movie;
    }

    public function update($movie, $requestData): Movie
    {
        $movie->setTitle($requestData->title);
        $movie->setDescription($requestData->description);
        $movie->setGenreId($requestData->genre_id);
        $movie->setReleaseDate($requestData->release_date);
        $movie->setTrailerLink($requestData->trailer_link);
        $movie->setCover($requestData->cover);
        $movie->setDuration($requestData->duration);
        $movie->update();

        return $movie;
    }
}
