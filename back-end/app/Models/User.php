<?php

namespace App\Models;

use PDO;
use Core\BaseModel;


class User extends BaseModel
{

    protected string $table = "users";

    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public string $password;
    public string $created_at;

    // construtor de basemodel??

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function findByEmail(string $email): User|array
    {
        $query = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? static::hydrate($result) : null;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
