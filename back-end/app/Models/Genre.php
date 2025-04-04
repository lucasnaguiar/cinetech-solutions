<?php

namespace App\Models;

use Core\BaseModel;
use Core\Database;

class Genre extends BaseModel
{
    protected string $table = "movie_genres";
    public int $id;
    public string $name;
    public string $slug;
    public ?string $description = null;

    public function setName(string $name): void
    {
        $this->name = $name;

        $this->slug = $this->generateUniqueSlug($this->name);
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
