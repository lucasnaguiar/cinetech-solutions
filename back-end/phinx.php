<?php

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__));
$dotenv->load();

if (empty($_ENV['DB_HOST']) || empty($_ENV['DB_NAME']) || empty($_ENV['DB_USER'])) {
    throw new RuntimeException('Configuração de banco de dados inválida. Verifique o arquivo config/database.php');
}

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'enviroment',
            'enviroment' => [
                'adapter' => $_ENV['DB_CONNECTION'],
                'host' => $_ENV['DB_HOST'],
                'name' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'pass' => $_ENV['DB_PASS'],
                'port' => $_ENV['DB_PORT'],
                'charset' => 'utf8',
            ],
            'testing' => [
                'adapter' => 'pgsql',
                'host' => 'product-postgres',
                'name' => 'testing_db',
                'user' => 'root',
                'pass' => '',
                'port' => '3306',
                'charset' => 'utf8',
            ]
        ],
        'version_order' => 'creation'
    ];
