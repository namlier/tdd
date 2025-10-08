<?php

declare(strict_types=1);

namespace Namlier\TDD\SQL;

use Namlier\TDD\SQL\StatementHelper;

class Select
{
    private string|array $fields;

    private string $from;

    private array $where = [];

    public function getStatement(): string
    {
        $this->ensureFromAndFieldsArePresent();

        $fields = $this->statementFields();
        $from = StatementHelper::wrapInBackticks($this->from);
        $where = $this->statementWhere();

        $statement = "SELECT {$fields} FROM {$from}";

        if ($where) {
            $statement.= " WHERE {$where}";
        }

        return $statement . ';';
    }

    public function getBoundedValues(): array
    {
        return StatementHelper::interpretBoundedValues($this->where);
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
        $this->where = $clause;
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

    private function statementFields(): string
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

        return StatementHelper::wrapInBackticks($this->fields);
    }

    private function statementWhere(): string
    {
        if (empty($this->where)) {
            return '';
        }

        $whereChunks = [];

        foreach ($this->where as $field => $value) {
            $wrappedField = StatementHelper::wrapInBackticks($field);
            $placeholder = StatementHelper::fieldToPlaceholder($field);

            $whereChunks[] = $wrappedField . ' = ' . $placeholder;
        }

        return implode(' AND ', $whereChunks);
    }
}
