<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class GenreSeeder extends AbstractSeed
{
    public function run(): void
    {
        if ($this->hasData()) {
            echo 'A tabela de gênero já contém dados. Seed não será executado.' . PHP_EOL;
            return;
        }

        $genres = [
            [
                'name' => 'Ação',
                'slug' => 'acao'
            ],
            [
                'name' => 'Aventura',
                'slug' => 'aventura'
            ],
            [
                'name' => 'Comédia',
                'slug' => 'comedia'
            ],
            [
                'name' => 'Drama',
                'slug' => 'drama'
            ],
            [
                'name' => 'Ficção Científica',
                'slug' => 'ficcao-cientifica'
            ],
            [
                'name' => 'Terror',
                'slug' => 'terror'
            ],
            [
                'name' => 'Romance',
                'slug' => 'romance'
            ],
            [
                'name' => 'Animação',
                'slug' => 'animacao'
            ],
            [
                'name' => 'Suspense',
                'slug' => 'suspense'
            ],
            [
                'name' => 'Fantasia',
                'slug' => 'fantasia'
            ]
        ];
    
        $this->table('movie_genres')->insert($genres)->save();
    }

    protected function hasData(): bool
{
    $count = $this->getAdapter()->fetchRow('SELECT COUNT(*) as count FROM movie_genres')['count'];
    return $count > 0;
}
}
