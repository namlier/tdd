<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\SQL;

use Namlier\UnitTesting\SQL\StatementHelper;

class Select
{
    private string|array $fields;

    private string $from;

    private array $whereClause = [];

    public function getStatement(): string
    {
        $this->ensureFromAndFieldsArePresent();

        $interpretedFields = $this->interpretFields();
        $interpretedFrom = $this->interpretFrom();
        $whereClause = $this->interpretWhere();

        $statement = "SELECT {$interpretedFields} FROM {$interpretedFrom}";

        if ($whereClause) {
            $statement.= " WHERE {$whereClause}";
        }

        return $statement . ';';
    }

    public function getBoundedValues(): array
    {
        return StatementHelper::interpretBoundedValues($this->whereClause);
    }

    public function fields(string|array $fields): void
    {
        $this->fields = $fields;
    }

    public function from(string $from): void
    {
        $this->from = $from;
    }

    public function where(array $clause): void
    {
        $this->whereClause = $clause;
    }

    private function ensureFromAndFieldsArePresent(): void
    {
        if (!isset($this->fields)) {
            throw new \Exception('Fields is a mandatory part of a statement.');
        }

        if (!isset($this->from)) {
            throw new \Exception('From is a mandatory part of a statement.');
        }
    }

    private function interpretFields(): string
    {
        if (is_array($this->fields)) {
            return StatementHelper::interpretFieldsFromArray($this->fields);
        }

        return $this->interpretFieldsFromString();
    }

    private function interpretFieldsFromString(): string
    {
        if ($this->fields === '*') {
            return '*';
        }

        return StatementHelper::interpretFieldsFromString($this->fields);
    }

    private function interpretFrom(): string
    {
        return StatementHelper::purifyStatementIdentifier($this->from);
    }

    private function interpretWhere(): string
    {
        if (empty($this->whereClause)) {
            return '';
        }

        $whereChunks = [];

        foreach ($this->whereClause as $field => $value) {
            $purifiedField = StatementHelper::purifyStatementIdentifier($field);
            $placeholder = StatementHelper::identifierToPlaceholder($field);

            $whereChunks[] = $purifiedField . ' = ' . $placeholder;
        }

        return implode(' AND ', $whereChunks);
    }
}
