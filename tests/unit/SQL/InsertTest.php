<?php

declare(strict_types=1);

namespace SQL;

use Namlier\TDD\SQL\Insert;
use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{
    public function testTableNameIsMandatoryPartOfStatement(): void
    {
        $sut = new Insert();

        self::expectExceptionMessage('Table name is a mandatory part of the "INSERT" statement.');

        $sut->getStatement();
    }

    public function testValuesIsMandatoryPartOfStatement(): void
    {
        $sut = new Insert();
        $sut->into('table_name');

        self::expectExceptionMessage('Values is a mandatory part of the "INSERT" statement.');

        $sut->getStatement();
    }

    public function testGetStatementWorksWithMandatoryParts(): void
    {
        $sut = new Insert();
        $sut->into('table_name');
        $sut->values(['name' => 'John', 'email' => 'johndoe@gmail.com']);

        $resultStatement = $sut->getStatement();
        $resultBoundedValues = $sut->getBoundedValues();

        self::assertEquals(
            "INSERT INTO `table_name` (`name`, `email`) VALUES (:name, :email);",
            $resultStatement,
            'It is should be possible to create a statement with provided Table name and Values parts.'
        );

        self::assertEquals(
            [':name' => 'John', ':email' => 'johndoe@gmail.com'],
            $resultBoundedValues
        );
    }
}
