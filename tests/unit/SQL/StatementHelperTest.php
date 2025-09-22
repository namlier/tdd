<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Namlier\UnitTesting\SQL\StatementHelper;

class StatementHelperTest extends TestCase
{
    #[DataProvider('tableAndFieldIdentifiersProvider')]
    public function testPurifyStatementIdentifier(string $input, string $expectedOutput): void
    {
        $result = StatementHelper::purifyStatementIdentifier($input);

        self::assertEquals($expectedOutput, $result);
    }

    #[DataProvider('valuesProvider')]
    public function testPurifyValue(string $input, string $expectedOutput): void
    {
        $result = StatementHelper::purifyFieldValue($input);

        self::assertEquals($expectedOutput, $result);
    }

    #[DataProvider('arrayFieldsProvider')]
    public function testInterpretFieldsFromArray(array $fields, string $expectedOutput): void
    {
        $result = StatementHelper::interpretFieldsFromArray($fields);

        self::assertEquals($expectedOutput, $result);
    }

    #[DataProvider('stringFieldsProvider')]
    public function testInterpretFieldsFromString(string $fields, string $expectedOutput): void
    {
        $result = StatementHelper::interpretFieldsFromString($fields);

        self::assertEquals($expectedOutput, $result);
    }

    public static function tableAndFieldIdentifiersProvider(): array
    {
        return [
            ['table_name_or_field', '`table_name_or_field`'],
            ['`table_name_or_field`', '`table_name_or_field`'],
            ['`table_name_or_field', '`table_name_or_field`'],
            [' table_name_or_field ', '`table_name_or_field`'],
        ];
    }

    public static function valuesProvider(): array
    {
         return [
             ['id', ':id'],
             [':name', ':name'],
             [': email', ':email'],
             [' :id ', ':id'],
             [' id ', ':id']
         ];
    }

    public static function arrayFieldsProvider(): array
    {
        $expectedResult = '`id`, `name`, `email`';

        return [
            [['id', 'name', 'email'], $expectedResult],
            [[' id ', ' name ', ' email '], $expectedResult],
            [['id` ', '` name` ', 'email `'], $expectedResult],
        ];
    }

    public static function stringFieldsProvider(): array
    {
        $expectedResult = '`id`, `name`, `email`';

        return [
            ['id,name, email', $expectedResult],
            [' id, `name, `email`', $expectedResult]
        ];
    }
}
