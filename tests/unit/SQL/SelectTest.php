<?php

declare(strict_types=1);

namespace SQL;

use Namlier\UnitTesting\SQL\Select;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    public function testFieldsIsMandatoryPartOfStatement(): void
    {
        $sut = new Select();

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Fields is a mandatory part of a statement.');

        $sut->getStatement();

    }

    public function testFromIsMandatoryPartOfStatement(): void
    {
        $sut = new Select();
        $sut->fields('*');

        self::expectException(\Exception::class);
        self::expectExceptionMessage('From is a mandatory part of a statement.');

        $sut->getStatement();
    }

    public function testGetStatementWillWorkWithFromAndFieldsParts(): void
    {
        $sut = new Select();
        $sut->fields('*');
        $sut->from('users');

        $result = $sut->getStatement();

        self::assertEquals('SELECT * FROM `users`;', $result);
    }

    #[DataProvider('fieldsTestProvider')]
    public function testFieldsMethodInvocationPatterns(string|array $fields, string $from, string $expectedStatement, string $messageOnFail): void
    {
        $sut = new Select();
        $sut->fields($fields);
        $sut->from($from);

        $result = $sut->getStatement();

        self::assertEquals($expectedStatement, $result, $messageOnFail);
    }

    #[DataProvider('whereClauseProvider')]
    public function testWhereClause(array $whereClause, string $expectedStatement, array $expectedBoundedValues): void
    {
        $sut = new Select();
        $sut->fields('*');
        $sut->from('users');
        $sut->where($whereClause);

        $resultStatement = $sut->getStatement();
        $resultBoundedValues = $sut->getBoundedValues();

        self::assertEquals($expectedStatement, $resultStatement);
        self::assertEquals($expectedBoundedValues, $resultBoundedValues);
    }

    public static function fieldsTestProvider(): array
    {
        return [
            ['*', 'users', 'SELECT * FROM `users`;', 'Fields should work with provided asterisk "*".'],
            [['id', 'name', 'email'], 'users', "SELECT `id`, `name`, `email` FROM `users`;", 'Fields should work with provided array.'],
            ['id,name, email', 'users', "SELECT `id`, `name`, `email` FROM `users`;", 'Fields should work with listed fields as string.'],
            ['`id`, `name`,`email`', 'users', "SELECT `id`, `name`, `email` FROM `users`;", 'Fields should work with listed fields wrapped in backticks as string.']
        ];
    }

    public static function whereClauseProvider(): array
    {
        return [
            [['id' => 5], 'SELECT * FROM `users` WHERE `id` = :id;', [':id' => 5]],
            [
                ['id' => 5, 'name' => 'Sasha'],
                'SELECT * FROM `users` WHERE `id` = :id AND `name` = :name;',
                [':id' => 5, ':name' => 'Sasha']
            ],
        ];
    }
}
