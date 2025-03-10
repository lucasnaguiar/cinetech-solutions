<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMoviesTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('movies');
        $table->addColumn('title', 'string')
            ->addColumn('description', 'text')
            ->addColumn('genre_id', 'integer')
            ->addColumn('cover', 'text')
            ->addColumn('trailer_link', 'text')
            ->addColumn('release_date', 'datetime')
            ->addColumn('duration', 'text')
            ->create();
    }

    public function down(): void
    {
        $this->table('movies')->drop()->save();
    }
}
