<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run(): void
    {
        if ($this->hasData()) {
            echo 'A tabela users já contém dados. Seed não será executado.' . PHP_EOL;
            return;
        }

        $data = [
            [
                "username" => "lucasnaguiar",
                "name" => "Lucas Aguiar",
                "email" => "lucasbarbary@gmail.com",
                "password" => password_hash("teste@123", PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                "username" => "samuel",
                "name" => "Samuel",
                "email" => "samuel@gmail.com",
                "password" => password_hash("teste@123", PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->table('users')->insert($data)->saveData();
    }

    protected function hasData(): bool
    {
        $count = $this->getAdapter()->fetchRow('SELECT COUNT(*) as count FROM users')['count'];
        return $count > 0;
    }
}
