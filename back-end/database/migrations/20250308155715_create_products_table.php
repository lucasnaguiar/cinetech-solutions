<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductsTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('products');
        $table->addColumn('name', 'string')
              ->addColumn('description', 'text')
              ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2])
              ->addColumn('stock_quantity', 'integer')
              ->addColumn('created_at', 'datetime')
              ->create();
    }

    public function down(): void
    {
        $this->table('products')->drop()->save();
    }
}
