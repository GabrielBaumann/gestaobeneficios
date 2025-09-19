<?php

namespace Source\Core;

use Source\Support\Message;

abstract class Model
{
    /** @var object|null */
    protected $data;

    /** @var \PDOException|null */
    protected $fail;

    /** @var Message|null */
    protected $message;

    protected $query;

    protected $params;

    protected $order;

    protected $limit;

    protected $offset;

    /** @var string $entity database table */
    protected static $entity;

    /** @var array $protected no update or create */
    protected static $protected;

    /** @var array $entity database table */
    protected static $required;

    // Atributo que muda o nome do id da tabela
    protected $id;

    // SELECT INNER JOIN
    protected array $select = [];
    protected array $join = [];
    protected array $where = [];
    protected array $paramsSelect = [];
    protected array $orderBy = [];
    protected ?int  $limitJoin = null;
    protected ?int  $offsetJoin = null;

    /**
     * Model constructor.
     * @param string $entity database table name
     * @param array $protected table protected columns
     * @param array $required table required columns
     */
    public function __construct(string $entity, array $protected, array $required, string $id = "id")
    {
        self::$entity = $entity;
        self::$protected = array_merge($protected, ["date_register", "date_update"]);
        self::$required = $required;
        $this->id = $id;
        $this->message = new Message();
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if ($name === "id") {
        return;
        }

        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    /**
     * @return null|object
     */
    public function data(): ?object
    {
        return $this->data;
    }

    /**
     * @return \PDOException
     */
    public function fail(): ?\PDOException
    {
        return $this->fail;
    }

    /**
     * @return Message|null
     */
    public function message(): ?Message
    {
        return $this->message;
    }

    public function find(?string $terms = null, ?string $params = null, string $columns = "*")
    {
        if ($terms) {
            $this->query = "SELECT {$columns} FROM " . static::$entity . " WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }
        
        $this->query = "SELECT {$columns} FROM " . static::$entity;
        return $this;
    }


    public function findById(int $id, string $columns = "*"): ?Model
    {
        // var_dump($this->id);
        $find = $this->find($this->id . " = :id", "id={$id}", $columns);
        return $find->fetch();
    }

    public function order(string $columnOrder, ?string $direct = "ASC"): Model
    {
        $this->order = " ORDER BY {$columnOrder} {$direct}";
        return $this;
    }

    public function limit(int $limit): Model
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    public function offset(int $offset): Model
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    public function fetch(bool $all = false)
    {
        try {
            $stmt = Connect::getInstance()->prepare($this->query . $this->order . $this->limit . $this->offset);
            $stmt->execute($this->params);
            
            if (!$stmt->rowCount()) {
                return null;
            }

            if ($all) {
                return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
            }

            return $stmt->fetchObject(static::class);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    public function count(string $key = "id")
    {
        $stmt = Connect::getInstance()->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    /**
     * @param string $entity
     * @param array $data
     * @return int|null
     */
    protected function create(array $data): ?int
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connect::getInstance()->prepare("INSERT INTO " . static::$entity . " ({$columns}) VALUES ({$values})");
            $stmt->execute($this->filter($data));
            
            return Connect::getInstance()->lastInsertId();
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $entity
     * @param array $data
     * @param string $terms
     * @param string $params
     * @return int|null
     */
    protected function update(array $data, string $terms, string $params): ?int
    {
        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);
            parse_str($params, $params);

            $stmt = Connect::getInstance()->prepare("UPDATE " . static::$entity . " SET {$dateSet} WHERE {$terms}");
            $stmt->execute($this->filter(array_merge($data, $params)));
            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    public function save() : bool 
    {
        if (!$this->required()) {
            $this->message->warning("Preencha todos os campos para continuar");
            return false;
        }

        $primaryKey = $this->id;

        // Atualizar
        if (!empty($this->$primaryKey)) {
            $id = $this->$primaryKey;

            $this->update($this->safe(), $this->id . " = :id", "id={$id}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        // Criar
        if (empty($this->$primaryKey)) {
            
            $id = $this->create($this->safe());

            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }
        
        $this->data = $this->findById($id)->data();
        return true;
    }

    /**
     * @param string $entity
     * @param string $terms
     * @param string $params
     * @return int|null
     */
    public function delete(string $terms, ?string $params): bool
    {
        try {
            $stmt = Connect::getInstance()->prepare("DELETE FROM " . static::$entity . " WHERE {$terms}");

            if ($params) {
                parse_str($params, $params);
                $stmt->execute($params);
                return true;
            }

            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    public function destroy() : bool
    {
        // Pegar o valor do ID e não o nome do campo do id
        $valuePrimaryKey = $this->id;
        $id = $this->$valuePrimaryKey;

        if (empty($id)) {
            return false;
        }

        $destroy = $this->delete($this->id . " = :id", "id={$id}");
        
        return $destroy;
    }

    /**
     * @return array|null
     */
    protected function safe(): ?array
    {
        $safe = (array)$this->data;

        if (isset($safe['id']) && $safe['id'] === $this->id) {
            unset($safe['id']);
        }

        foreach (static::$protected as $unset) {
            unset($safe[$unset]);
        }
        return $safe;
    }

    /**
     * @param array $data
     * @return array|null
     */
    private function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }
        return $filter;
    }

    /**
     * @return bool
     */
    protected function required(): bool
    {
        $data = (array)$this->data();
        foreach (static::$required as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }
        return true;
    }
}