<?php

declare(strict_types=1);

namespace Namlier\TDD\SQL;

use Namlier\TDD\SQL\StatementHelper;

class Insert
{
    private readonly string $tableName;

    private readonly array $values;

    public function getStatement(): string
    {
        $this->ensureMandatoryParts();

        $tableName = StatementHelper::wrapInBackticks($this->tableName);
        $fields = StatementHelper::interpretFieldsFromArray(array_keys($this->values));
        $values = $this->interpretValues();

        return "INSERT INTO {$tableName} ({$fields}) VALUES ({$values});";
    }

    public function getBoundedValues(): array
    {
        return StatementHelper::interpretBoundedValues($this->values);
    }

    public function into(string $tableName): void
    {
        $this->tableName = $tableName;
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

        if (!isset($this->values)) {
            throw new \Exception('Values is a mandatory part of the "INSERT" statement.');
        }
    }

    private function interpretValues(): string
    {
        $placeholders = [];
        $fields = array_keys($this->values);

        foreach ($fields as $field) {
            $placeholders[] = StatementHelper::fieldToPlaceholder($field);
        }

        return implode(', ', $placeholders);
    }
}
