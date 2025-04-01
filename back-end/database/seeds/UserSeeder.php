<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {

        $data = [
            [
                "username" => "lucasnaguiar",
                "name" => "Lucas Aguiar",
                "email" => "lucasbarbary@gmail.com",
                "password" => password_hash("teste@123", PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                "username" => "joaonobrega",
                "name" => "João Nobrega",
                "email" => "joaonobrega31@gmail.com",
                "password" => password_hash("nobrega@2024", PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->table('users')->insert($data)->saveData();
    }
}
