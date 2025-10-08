<?php

declare(strict_types=1);

namespace SQL;

use Namlier\TDD\SQL\DB;
use Namlier\TDD\SQL\Insert;
use PHPUnit\Framework\TestCase;
use SQLite3;
use SQLite3Stmt;
use Namlier\TDD\SQL\Select;

class DBTest extends TestCase
{
    public function testInsertThrowsExceptionOnFailedStatementPreparing(): void
    {
        $sqlite = $this->createStub(SQLite3::class);
        $sqlite->method('prepare')
            ->willReturn(false);
        $sqlite->method('lastErrorMsg')
            ->willReturn('near "INSRET": syntax error');
        $sut = new DB($sqlite);

        $insert = new Insert();
        $insert->into('table_name');
        $insert->values([]);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('near "INSRET": syntax error');

        $sut->insert($insert);
    }

    public function testInsertThrowsExceptionOnFailedStatementExecuting(): void
    {
        $sqlite = $this->createStub(SQLite3::class);
        $sqliteStatement = $this->createStub(SQLite3Stmt::class);
        $sqlite->method('prepare')
            ->willReturn($sqliteStatement);
        $sqliteStatement->method('execute')
            ->willReturn(false);
        $sqlite->method('lastErrorMsg')
            ->willReturn('UNIQUE constraint failed: users.id');

        $sut = new DB($sqlite);
        $insert = new Insert();
        $insert->into('table_name');
        $insert->values([]);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('UNIQUE constraint failed: users.id');

        $sut->insert($insert);
    }

    public function testSelectOneThrowsExceptionOnFailedStatementPreparing(): void
    {
        $sqlite = $this->createStub(SQLite3::class);
        $sqlite->method('prepare')
            ->willReturn(false);
        $sqlite->method('lastErrorMsg')
            ->willReturn('near "SELEC": syntax error');

        $select = new Select();
        $select->fields('*');
        $select->from('users');
        $sut = new DB($sqlite);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('near "SELEC": syntax error');

        $sut->selectOne($select);
    }

    public function testSelectOneThrowsExceptionOnFailedStatementExecution(): void
    {
        $sqlite = $this->createStub(SQLite3::class);
        $sqliteStatement = $this->createStub(SQLite3Stmt::class);
        $sqlite->method('prepare')
            ->willReturn($sqliteStatement);
        $sqliteStatement->method('execute')
            ->willReturn(false);
        $sqlite->method('lastErrorMsg')
            ->willReturn('Exception: no such column: absent_column');

        $select = new Select();
        $select->fields(['absent_column']);
        $select->from('users');
        $sut = new DB($sqlite);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Exception: no such column: absent_column');

        $sut->selectOne($select);
    }
}
