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

    public function testFieldsWhenAsteriskProvided(): void
    {
        $sut = new Select();
        $sut->fields('*');
        $sut->from('users');

        $result = $sut->getStatement();

        self::assertEquals('SELECT * FROM `users`;', $result, 'Fields should work with provided asterisk "*".');
    }

    public function testFieldsWhenArrayProvided(): void
    {
        $sut = new Select();
        $sut->fields(['name', 'id']);
        $sut->from('users');

        $result = $sut->getStatement();

        self::assertEquals(
            'SELECT `name`, `id` FROM `users`;',
            $result,
            'Fields should work with provided array.'
        );
    }

    public function testFieldsWhenStringProvided(): void
    {
        $sut = new Select();
        $sut->fields('id');
        $sut->from('users');

        $result = $sut->getStatement();

        self::assertEquals(
            'SELECT `id` FROM `users`;',
            $result,
            'Fields should work with provided single field as string.'
        );
    }

    public function testWhereClause(): void
    {
        $sut = new Select();
        $sut->fields('*');
        $sut->from('users');
        $sut->where(['name' => 'John', 'email' => 'johndoe@gmail.com']);

        $resultStatement = $sut->getStatement();
        $resultBoundedValues = $sut->getBoundedValues();

        self::assertEquals('SELECT * FROM `users` WHERE `name` = :name AND `email` = :email;', $resultStatement);
        self::assertEquals([':name' => 'John', ':email' => 'johndoe@gmail.com'], $resultBoundedValues);
    }
}
