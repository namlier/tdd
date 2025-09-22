<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\Sqlite;

use SQLite3;

class DB extends SQLite3
{
    public function __construct(private readonly string $fileName)
    {
        $this->open($this->fileName);
    }

    public function insert(string $tableName, array $data): void
    {
        $keys = '(' . implode(',', array_keys($data)) . ')';

        foreach ($data as &$value) {
            $value = "'{$value}'";
        }
        $values = '(' . implode(',', $data) . ')';

        $exec = $this->exec("INSERT INTO {$tableName} {$keys} VALUES {$values}");

        if (!$exec) {
            throw new \Exception($this->lastErrorMsg());
        }
    }

    public function queryAll(string $tableName, array $conditions = []): array
    {
        $query = $this->query("SELECT * FROM {$tableName}");
        $result = [];

        while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row;
        }

        return $result;
    }
}
