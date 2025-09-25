<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\SQL;

class StatementHelper
{
    public static function purifyStatementIdentifier(string $identifier): string
    {
        $text = str_replace('`', '', $identifier);
        $text = trim($text);

        return "`{$text}`";
    }

    public static function identifierToPlaceholder(string $identifier): string
    {
        $text = str_replace('`', '', $identifier);
        $text = trim($text);

        return ":{$text}";
    }

    public static function interpretFieldsFromArray(array $fields): string
    {
        $purifiedFields = [];

        foreach ($fields as $field) {
            $purifiedFields[] = StatementHelper::purifyStatementIdentifier($field);
        }

        return implode(', ', $purifiedFields);
    }

    public static function interpretFieldsFromString(string $fields): string
    {
        $fields = explode(',', $fields);
        $purifiedFields = [];

        foreach ($fields as $field) {
            $purifiedFields[] = StatementHelper::purifyStatementIdentifier($field);
        }

        return implode(', ', $purifiedFields);
    }

    public static function interpretBoundedValues(array $values): array
    {
        $boundedValues = [];

        foreach ($values as $field => $value) {
            $boundedValues = array_merge($boundedValues, [self::identifierToPlaceholder($field) => $value]);
        }

        return $boundedValues;
    }
}
