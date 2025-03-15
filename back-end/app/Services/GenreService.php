<?php

namespace App\Services;

use App\Models\Genre;

class GenreService
{
    public function store($requestData): Genre
    {
        $genre = new Genre();
        $genre->name = $requestData->name;
        $genre->description = $requestData->description;

        $genre->save();

        return $genre;
    }

    public function update($genre, $requestData): Genre
    {
        $genre->name = $requestData->name;
        $genre->description = $requestData->description;
        $genre->update();

        return $genre;
    }
}
