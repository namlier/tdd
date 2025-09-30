<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\SQL;

use SQLite3;

class DB
{
    public function __construct(private readonly SQLite3 $SQLite3) {}

    public function insert(Insert $insert): void
    {
        $preparedStatement = $this->SQLite3->prepare($insert->getStatement());
        $this->ensureSQLiteMethodSucceed($preparedStatement);
        $boundedValues = $insert->getBoundedValues();

        foreach ($boundedValues as $field => $value) {
            $preparedStatement->bindValue($field, $value);
        }

        $sqliteResult = $preparedStatement->execute();
        $this->ensureSQLiteMethodSucceed($sqliteResult);
    }

    public function selectOne(Select $select): array
    {
        $preparedStatement = $this->SQLite3->prepare($select->getStatement());
        $this->ensureSQLiteMethodSucceed($preparedStatement);

        foreach ($select->getBoundedValues() as $field => $value) {
            $preparedStatement->bindValue($field, $value);
        }

        $sqliteResult = $preparedStatement->execute();
        $this->ensureSQLiteMethodSucceed($sqliteResult);
        $result = $sqliteResult->fetchArray(SQLITE3_ASSOC);

        return $result;
    }

    public function lastInsertRowID(): int
    {
        return $this->SQLite3->lastInsertRowID();
    }

    private function ensureSQLiteMethodSucceed(mixed $SQLiteMethodResult): void
    {
        if ($SQLiteMethodResult === false) {
            throw new \Exception($this->SQLite3->lastErrorMsg());
        }
    }
}
