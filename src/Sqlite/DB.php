<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\Sqlite;

use SQLite3;

class DB extends SQLite3
{
    public function __construct(string $filename)
    {
        parent::__construct($filename);
    }

    public function insert(): void
    {

    }
}