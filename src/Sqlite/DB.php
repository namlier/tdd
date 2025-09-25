<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\Sqlite;

use Namlier\UnitTesting\SQL\Insert;
use Namlier\UnitTesting\SQL\Select;
use SQLite3;

class DB extends SQLite3
{
    public function __construct(private readonly string $fileName)
    {
        $this->open($this->fileName);
    }

    public function insert(Insert $insert): void
    {
        $preparedStatement = $this->prepare($insert->getStatement());
        $boundedValues = $insert->getBoundedValues();

        foreach ($boundedValues as $field => $value) {
            $preparedStatement->bindValue($field, $value);
        }

        $sqliteResult = $preparedStatement->execute();

        if (!$sqliteResult) {
            throw new \Exception($this->lastErrorMsg());
        }
    }

    public function selectOne(Select $select): array
    {
        $preparedStatement = $this->prepare($select->getStatement());

        foreach ($select->getBoundedValues() as $field => $value) {
            $preparedStatement->bindValue($field, $value);
        }

        $sqliteResult = $preparedStatement->execute();
        $result = $sqliteResult->fetchArray(SQLITE3_ASSOC);

        if (!$result) {
            throw new \Exception($this->lastErrorMsg());
        }

        return $result;
    }
}
