<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\SQL;

use Namlier\UnitTesting\SQL\StatementHelper;

class Insert
{
    private readonly string $tableName;

    private readonly array $fields;

    private readonly array $values;

    public function getStatement(): string
    {
        $this->ensureMandatoryParts();

        $tableName = StatementHelper::purifyStatementIdentifier($this->tableName);
        $values = $this->interpretValues();

        return "INSERT INTO {$tableName} VALUES ({$values});";
    }

    public function into(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    public function fields(array $fields): void
    {
        $this->fields = $fields;
    }

    public function values(array $values): void
    {
        $this->values = $values;
    }

    private function ensureMandatoryParts(): void
    {
        if (!isset($this->tableName)) {
            throw new \Exception('Table name is a mandatory part of the "INSERT" statement.');
        }

        if (!isset($this->fields)) {
            throw new \Exception('Fields is a mandatory part of the "INSERT" statement.');
        }

        if (!isset($this->values)) {
            throw new \Exception('Values is a mandatory part of the "INSERT" statement.');
        }
    }

    private function interpretValues(): string
    {
        $purifiedValues = [];

        foreach ($this->values as $value) {
            $purifiedValues[] = StatementHelper::purifyFieldValue($value);
        }

        return implode(', ', $purifiedValues);
    }
}
