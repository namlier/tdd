<?php

declare(strict_types=1);

namespace SQL;

use Namlier\UnitTesting\SQL\Insert;
use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{
    public function testTableNameIsMandatoryPartOfStatement(): void
    {
        $sut = new Insert();

        self::expectExceptionMessage('Table name is a mandatory part of the "INSERT" statement.');

        $sut->getStatement();
    }

    public function testFieldsIsMandatoryPartOfStatement(): void
    {
        $sut = new Insert();
        $sut->into('table_name');

        self::expectExceptionMessage('Fields is a mandatory part of the "INSERT" statement.');

        $sut->getStatement();
    }

    public function testValuesIsMandatoryPartOfStatement(): void
    {
        $sut = new Insert();
        $sut->into('table_name');
        $sut->fields(['name']);

        self::expectExceptionMessage('Values is a mandatory part of the "INSERT" statement.');

        $sut->getStatement();
    }

    public function testGetStatementWorksWithMandatoryParts(): void
    {
        $sut = new Insert();
        $sut->into('table_name');
        $sut->fields(['name', 'email']);
        $sut->values([':name', ':email']);

        $result = $sut->getStatement();

        self::assertEquals(
            "INSERT INTO `table_name` (`name`, `email`) VALUES (:name, :email);",
            $result,
            'It is should be possible to create a statement with provided Table name and Values parts.'
        );
    }
}
