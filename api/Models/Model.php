<?php

namespace App\Models;

use \PDO;
use \PDOException;
use App\Helpers\Database;

class Model
{
    private $query;
    private $bindings = [];
    private $orderBy = [];
    private $limitValue = null;
    private $offsetValue = null;

    protected $connection;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];

    public function __construct($connection = null)
    {
        $this->connection = $connection ?? Database::getInstance()->getConnection();
    }

    public function save()
    {
        try {
            $data = [];
            foreach ($this->fillable as $field) {
                if ($this->$field !== null) {
                    $data[$field] = $this->$field;
                }
            }

            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_map(fn($k) => ":$k", array_keys($data)));

            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);

            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    public function saveIgnore()
    {
        try {
            $data = [];
            foreach ($this->fillable as $field) {
                if ($this->$field !== null) {
                    $data[$field] = $this->$field;
                }
            }

            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_map(fn($k) => ":$k", array_keys($data)));

            $sql = "INSERT IGNORE INTO {$this->table} ($columns) VALUES ($placeholders)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);

            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    public function update($id = null)
    {
        try {
            $data = [];
            foreach ($this->fillable as $field) {
                if ($this->$field !== null) {
                    $data[$field] = $this->$field;
                }
            }

            if (empty($data)) {
                return false;
            }

            // if($id === null) {
            //     $id = $this->$primaryKey;
            // }

            $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
            $sql = "UPDATE {$this->table} SET $set WHERE {$this->primaryKey} = :id";

            $stmt = $this->connection->prepare($sql);
            $data['id'] = $id;

            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    public static function find($id, $connection = null)
    {
        try {
            $connection = $connection ?? Database::getInstance()->getConnection();

            $instance = new static();
            $stmt = $connection->prepare("SELECT * FROM " . $instance->table . " WHERE " . $instance->primaryKey . " = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }
    public static function delete($id, $connection = null)
    {
        try {
            $connection = $connection ?? Database::getInstance()->getConnection();

            $instance = new static();
            $stmt = $connection->prepare("DELETE FROM " . $instance->table . " WHERE " . $instance->primaryKey . " = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }

    public static function all($fields = ['*'])
    {
        try {
            $instance = new static();
            $connection = $instance->connection ?? Database::getInstance()->getConnection();

            $columns = implode(', ', $fields);
            $sql = "SELECT $columns FROM {$instance->table}";

            $stmt = $connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error (all): " . $e->getMessage());
            return [];
        }
    }

    public static function raw($sql, $params = [], $connection = null)
    {
        try {
            $connection = $connection ?? Database::getInstance()->getConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error (raw): " . $e->getMessage());
            return [];
        }
    }
    public static function rawPaginate(string $sql, array $params = [], int $page = 1, int $limit = 10)
    {
        try {
            $connection = Database::getInstance()->getConnection();

            $page = max(1, $page);
            $limit = max(1, $limit);
            $offset = ($page - 1) * $limit;

            // Count query
            $countSql = "SELECT COUNT(*) as total FROM ($sql) as count_table";
            $countStmt = $connection->prepare($countSql);
            $countStmt->execute($params);
            $total = (int) $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Data query
            $pagedSql = $sql . " LIMIT $limit OFFSET $offset";
            $stmt = $connection->prepare($pagedSql);
            $stmt->execute($params);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'data' => $data,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total' => $total,
                    'last_page' => ceil($total / $limit),
                ]
            ];
        } catch (PDOException $e) {
            error_log("Database Error (rawPaginate): " . $e->getMessage());
            return [
                'data' => [],
                'pagination' => []
            ];
        }
    }
    public static function where($field, $operator = '=', $value = null, $fields = ['*'])
    {
        $instance = new static();
        $instance->query = "SELECT " . implode(', ', $fields) . " FROM " . $instance->table;

        // Shorthand support -> where('state', 'active')
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $instance->query .= " WHERE $field $operator :$field";
        $instance->bindings[":$field"] = $value;

        return $instance;
    }

    // Add more conditions after the first where()
    public function andWhere($field, $operator = '=', $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->query .= " AND $field $operator :$field";
        $this->bindings[":$field"] = $value;
        return $this;
    }

    public function orWhere($field, $operator = '=', $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->query .= " OR $field $operator :$field";
        $this->bindings[":$field"] = $value;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC')
    {
        // Basic column sanitization (prevent SQL injection)
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $column)) {
            throw new \InvalidArgumentException("Invalid column name for orderBy");
        }

        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'])) {
            $direction = 'ASC';
        }

        $this->orderBy[] = "$column $direction";

        return $this;
    }
    public function limit($number)
    {
        $this->limitValue = (int)$number;
        return $this;
    }

    public function offset($number)
    {
        $this->offsetValue = (int)$number;
        return $this;
    }

    public function get(): array
    {
        try {
            $this->connection = $this->connection ?? Database::getInstance()->getConnection();

            if (!empty($this->orderBy)) {
                $this->query .= " ORDER BY " . implode(', ', $this->orderBy);
            }
            // Append LIMIT/OFFSET if set
            if ($this->limitValue !== null) {
                $this->query .= " LIMIT {$this->limitValue}";
            }

            if ($this->offsetValue !== null) {
                $this->query .= " OFFSET {$this->offsetValue}";
            }

            $stmt = $this->connection->prepare($this->query);
            foreach ($this->bindings as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (PDOException $e) {
            error_log("Database error in get method: " . $e->getMessage());
            return [];
        }
    }

    public function paginate($page = 1, $limit = 10)
    {
        $page = max(1, (int)$page);
        $limit = max(1, (int)$limit);
        $offset = ($page - 1) * $limit;

        // Get total count before limit/offset
        $total = $this->count();

        // Fetch results with pagination
        $this->limit($limit)->offset($offset);
        $data = $this->get();

        $pagination = [
            'current_page' => $page,
            'per_page' => $limit,
            'total' => $total,
            'last_page' => ceil($total / $limit),
        ];

        return [
            'data' => $data,
            'pagination' => $pagination
        ];
    }

    public function first()
    {
        $this->limit(1);
        $results = $this->get();
        return $results[0] ?? null;
    }
    public function count(): int
    {
        try {
            $this->connection = $this->connection ?? Database::getInstance()->getConnection();

            // Transform SELECT fields INTO COUNT(*)
            $countQuery = preg_replace('/SELECT\s+.+?\s+FROM/i', 'SELECT COUNT(*) as total FROM', $this->query);
            $stmt = $this->connection->prepare($countQuery);
            foreach ($this->bindings as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $row['total'];
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        }
    }
}
