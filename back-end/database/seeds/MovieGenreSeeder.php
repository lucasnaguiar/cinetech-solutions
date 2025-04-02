<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class MovieGenreSeeder extends AbstractSeed
{
    public function run(): void
    {

        if ($this->hasData()) {
            echo 'A tabela movie_genre_movie já contém dados. Seed não será executado.' . PHP_EOL;
            return;
        }

        $relations = [
            1 => [1],
            11 => [1],
            21 => [1],
            2 => [2],
            12 => [2],
            22 => [2],
            3 => [3],
            13 => [3],
            23 => [3],
            4 => [4],
            14 => [4],
            24 => [4],
            5 => [5],
            15 => [5],
            25 => [5],
            6 => [6],
            16 => [6],
            7 => [7],
            17 => [7],
            8 => [8],
            18 => [8],
            9 => [9],
            19 => [9],
            10 => [10],
            20 => [10],
            2 => [2, 10],
            5 => [5, 2],
            6 => [6, 9],
            10 => [10, 2],
            15 => [5, 9],
        ];

        $data = [];
        foreach ($relations as $movieId => $genreIds) {
            foreach ($genreIds as $genreId) {
                $data[] = [
                    'movie_id' => $movieId,
                    'genre_id' => $genreId
                ];
            }
        }

        $uniqueData = array_unique($data, SORT_REGULAR);
        $this->table('movie_genre_movie')->insert($uniqueData)->save();
        echo sprintf('Relações criadas: %d', count($uniqueData)) . PHP_EOL;
    }

    protected function hasData(): bool
    {
        $count = $this->getAdapter()->fetchRow('SELECT COUNT(*) as count FROM movie_genre_movie')['count'];
        return $count > 0;
    }

    public function getDependencies(): array
    {
        return [
            'GenreSeeder',
            'MovieSeeder'
        ];
    }
}
