<?php

namespace App\Models;

use Core\BaseModel;


class Genre extends BaseModel
{
    protected string $table = "movie_genres";
    public int $id;
    public string $name;
    public ?string $description = null;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
