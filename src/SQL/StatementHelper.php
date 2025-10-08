<?php

declare(strict_types=1);

namespace Namlier\TDD\SQL;

class StatementHelper
{
    public static function wrapInBackticks(string $identifier): string
    {
        $text = trim($identifier);

        return "`{$text}`";
    }

    public static function fieldToPlaceholder(string $identifier): string
    {
        $text = trim($identifier);

        return ":{$text}";
    }

    public static function interpretFieldsFromArray(array $fields): string
    {
        $purifiedFields = [];

        foreach ($fields as $field) {
            $purifiedFields[] = StatementHelper::wrapInBackticks($field);
        }

        return implode(', ', $purifiedFields);
    }

    public static function interpretBoundedValues(array $values): array
    {
        $boundedValues = [];

        foreach ($values as $field => $value) {
            $boundedValues = array_merge($boundedValues, [self::fieldToPlaceholder($field) => $value]);
        }

        return $boundedValues;
    }
}
