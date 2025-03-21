<?php

namespace App\Services;

use App\Models\Movie;

class MovieService
{
    public function store($requestData): Genre
    {
        $movie = new Movie();
        $movie->setName($requestData->name);
        $movie->setDescription = $requestData->description;

        $movie->save();

        return $movie;
    }

    public function update($movie, $requestData): Movie
    {
        $movie->name = $requestData->name;
        $movie->description = $requestData->description;
        $movie->update();

        return $movie;
    }
}
