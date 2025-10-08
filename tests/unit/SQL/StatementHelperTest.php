<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Namlier\TDD\SQL\StatementHelper;

class StatementHelperTest extends TestCase
{
    #[DataProvider('tableAndFieldIdentifiersProvider')]
    public function testPurifyStatementIdentifier(string $input, string $expectedOutput): void
    {
        $result = StatementHelper::wrapInBackticks($input);

        self::assertEquals($expectedOutput, $result);
    }

    #[DataProvider('identifiersProvider')]
    public function testIdentifierToPlaceholder(string $input, string $expectedOutput): void
    {
        $result = StatementHelper::fieldToPlaceholder($input);

        self::assertEquals($expectedOutput, $result);
    }

    #[DataProvider('arrayFieldsProvider')]
    public function testInterpretFieldsFromArray(array $fields, string $expectedOutput): void
    {
        $result = StatementHelper::interpretFieldsFromArray($fields);

        self::assertEquals($expectedOutput, $result);
    }

    public function testInterpretBoundedValues(): void
    {
        $result = StatementHelper::interpretBoundedValues(['id' => 5, 'name' => 'Sasha']);

        self::assertEquals([':id' => 5, ':name' => 'Sasha'], $result);
    }

    public static function tableAndFieldIdentifiersProvider(): array
    {
        return [
            ['table_name_or_field', '`table_name_or_field`'],
            [' table_name_or_field ', '`table_name_or_field`'],
        ];
    }

    public static function identifiersProvider(): array
    {
         return [
             ['id', ':id'],
             ['name ', ':name'],
             [' email', ':email'],
         ];
    }

    public static function arrayFieldsProvider(): array
    {
        $expectedResult = '`id`, `name`, `email`';

        return [
            [['id', 'name', 'email'], $expectedResult],
            [[' id ', ' name ', ' email '], $expectedResult],
        ];
    }
}
