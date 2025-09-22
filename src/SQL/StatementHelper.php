<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\SQL;

class StatementHelper
{
    public static function purifyStatementIdentifier(string $text): string
    {
        $text = str_replace('`', '', $text);
        $text = trim($text);

        return "`{$text}`";
    }

    public static function purifyFieldValue(string $text): string
    {
        $text = str_replace(':', '', $text);
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
}
