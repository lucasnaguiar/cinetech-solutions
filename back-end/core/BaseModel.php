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

    public function findBySlug(string $slug): ?static
    {
        $query = "SELECT * FROM {$this->table} WHERE slug = :slug";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['slug' => $slug]);

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

    public function findWhereLike(string $column, string $value): array
    {
        $conditions = [];
        $params = [];

        $condition = "{$column} LIKE :{$column}";
        $params[":{$column}"] = "%{$value}%";

        $query = "SELECT * FROM {$this->table} WHERE {$condition} LIMIT 100";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? static::hydrateCollection($result) : [];
    }

    public function create(array $data): static
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Os dados para inserção não podem estar vazios.');
        }

        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);

        $query = "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";

        $stmt = $this->db->prepare($query);
        $stmt->execute($data);

        return $this->findById($this->db->lastInsertId());
    }

    public function save(): static
    {
        $properties = get_object_vars($this);
        $filteredData = array_filter($properties, fn($key) => $key !== 'db' && $key !== 'table', ARRAY_FILTER_USE_KEY);

        if (empty($filteredData)) {
            throw new InvalidArgumentException('Nenhuma propriedade válida encontrada para salvar.');
        }

        $columns = array_keys($filteredData);
        $placeholders = array_map(fn($col) => ":$col", $columns);

        $query = "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $this->db->prepare($query);
        $stmt->execute($filteredData);

        return $this->findById($this->db->lastInsertId());
    }

    public function update(): static
    {
        $properties = get_object_vars($this);

        // Filtrar propriedades válidas (excluindo db e table)
        $filteredData = array_filter($properties, fn($key) => $key !== 'db' && $key !== 'table', ARRAY_FILTER_USE_KEY);

        if (empty($filteredData)) {
            throw new InvalidArgumentException('Nenhuma propriedade válida encontrada para atualizar.');
        }

        if (!isset($filteredData['id'])) {
            throw new InvalidArgumentException('O objeto precisa ter um ID definido para ser atualizado.');
        }

        $id = $filteredData['id'];
        unset($filteredData['id']);

        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($filteredData)));

        $query = "UPDATE {$this->table} SET {$setClause} WHERE id = :id";

        $filteredData['id'] = $id;

        $stmt = $this->db->prepare($query);
        $stmt->execute($filteredData);

        return $this->findById($id);
    }

    public function delete(): bool
    {
        $properties = get_object_vars($this);

        $filteredData = array_filter($properties, fn($key) => $key !== 'db' && $key !== 'table', ARRAY_FILTER_USE_KEY);

        $id = $filteredData['id'];

        if (!isset($id)) {
            throw new InvalidArgumentException('O objeto precisa ter um ID definido para ser excluído.');
        }

        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $success = $stmt->execute(['id' => $id]);

        return $success;
    }

    /**
     * Verifica se um slug já existe na tabela
     */
    protected function slugExists(string $slug, ?int $excludingId = null): bool
    {
        $query = "SELECT id FROM {$this->table} WHERE slug = :slug";
        $params = ['slug' => $slug];
        
        if ($excludingId !== null) {
            $query .= " AND id != :id";
            $params['id'] = $excludingId;
        }
        
        $query .= " LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        
        return (bool) $stmt->fetch();
    }

    /**
     * Gera um slug único baseado em um valor
     */
    public function generateUniqueSlug(string $value, ?int $excludingId = null): string
    {
        $slug = slugify($value);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug, $excludingId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Valida se um slug é único (opcionalmente excluindo um ID)
     * @throws Exception Se o slug já existir
     */
    public function validateUniqueSlug(string $slug, ?int $excludingId = null): void
    {
        if ($this->slugExists($slug, $excludingId)) {
            throw new Exception("Já existe um registro com o slug '{$slug}'");
        }
    }

    public function validateIdsExist(array $ids, string $table, string $column = 'id'): void
    {
        if (empty($ids)) {
            return;
        }

        // Remove duplicados e valores vazios
        $ids = array_unique(array_filter($ids));
        
        if (empty($ids)) {
            throw new Exception("Nenhum ID válido foi fornecido");
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} IN ({$placeholders})";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute(array_values($ids));
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] !== count($ids)) {
            throw new Exception("Um ou mais IDs não existem na tabela {$table}");
        }
    }
}
