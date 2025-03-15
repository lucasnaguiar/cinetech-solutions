<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateGenreMovieTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('movie_genre_movie', ['id' => false, 'primary_key' => ['movie_id', 'genre_id']]);
        $table
            ->addColumn('movie_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('genre_id', 'integer', ['signed' => false, 'null' => false])
            ->addForeignKey('movie_id', 'movies', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('genre_id', 'movie_genres', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }

    public function down(): void
    {
        $this->table('movie_genre_movie')->drop()->save();
    }
}
