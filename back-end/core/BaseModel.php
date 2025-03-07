<?php

namespace Core;

use Exception;
use InvalidArgumentException;
use PDO;

abstract class BaseModel
{
    protected $db;
    protected string $table;

    public function __construct()
    {
        if (empty($this->table)) {
            throw new Exception('A propriedade "table" deve ser definida na classe que extende BaseModel.');
        }

        $this->db = Database::getConnection();
    }

    public static function hydrate(array $data): static
    {
        $instance = new static(); // Cria uma instância da classe que chamou
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->{$key} = $value;
            }
        }
        return $instance;
    }

    public static function hydrateCollection(array $data): array
    {
        return array_map(fn($item) => static::hydrate($item), $data);
    }

    public function findAll($limit = 100): array
    {
        $query = "SELECT * FROM {$this->table} LIMIT {$limit}";
        $stmt = $this->db->query($query);
        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? static::hydrateCollection($result) : [];
    }

    public function findById(int $id): ?static
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? static::hydrate($result) : null;
    }

    public function findByUuid(string $uuid): ?static
    {
        $query = "SELECT * FROM {$this->table} WHERE uuid = :uuid";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['uuid' => $uuid]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? static::hydrate($result) : null;
    }

    public function findWhere(array $where): array
    {
        if (empty($where)) {
            throw new InvalidArgumentException('O array $where não pode estar vazio.');
        }

        $conditions = [];
        $params = [];

        foreach ($where as $column => $value) {
            $conditions[] = "{$column} = :{$column}";
            $params[":{$column}"] = $value;
        }

        $whereClause = implode(' AND ', $conditions);
        $query = "SELECT * FROM {$this->table} WHERE {$whereClause} LIMIT 100";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? static::hydrateCollection($result) : [];
    }

    public function findWhereAndInArray(
        array $where,
        string $arrayColumn,
        array $values,
        int $limit = 100
    ): array {
        if (empty($where)) {
            throw new InvalidArgumentException('O array $where não pode estar vazio.');
        }

        $conditions = [];
        $params = [];

        foreach ($where as $column => $value) {
            $conditions[] = "{$column} = :{$column}";
            $params[":{$column}"] = $value;
        }

        $whereClause = implode(' AND ', $conditions);

        $query = "SELECT * FROM {$this->table} WHERE {$whereClause}";

        $valuesString = '{' . implode(',', $values) . '}';
        $query .= " AND {$arrayColumn} @> :arrayValues";
        $params[':arrayValues'] = $valuesString;

        $query .= " LIMIT :limit";
        $params[':limit'] = $limit;

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? static::hydrateCollection($result) : [];
    }
}
