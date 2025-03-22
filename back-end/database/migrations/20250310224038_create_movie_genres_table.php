<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMovieGenresTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('movie_genres');

        $table->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('description', 'text')
            ->create();
    }

    public function down(): void
    {
        $this->table('movie_genres')->drop()->save();
    }
}
