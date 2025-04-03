<?php

namespace App\Services;

use App\Models\Movie;

class MovieService
{
    public function store($requestData): Movie
    {
        $movie = new Movie();
        $movie->setTitle($requestData->title);
        $movie->setDescription($requestData->description);
        $movie->setReleaseDate($requestData->release_date);
        $movie->setTrailerLink($requestData->trailer_link);
        $movie->setCover('movie.svg');
        $movie->setDuration($requestData->duration);

        $movie = $movie->save();

        $movie->saveMovieGenres($requestData->genres);

        $movie->genres = $movie->getGenres();

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
