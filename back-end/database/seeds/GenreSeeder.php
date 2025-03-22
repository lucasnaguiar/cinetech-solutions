<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class GenreSeeder extends AbstractSeed
{
    public function run(): void
    {
        $genres = [
            ["Ação", "acao"],
            ["Aventura", "aventura"],
            ["Comédia", "comedia"],
            ["Drama", "drama"],
            ["Ficção Científica", "ficcao-cientifica"],
            ["Terror", "terror"],
            ["Romance", "romance"],
            ["Animação", "animacao"],
            ["Suspense", "suspense"],
            ["Fantasia", "fantasia"]
        ];

        $this->table('movie_genres')->insert($genres)->save();
    }
}
