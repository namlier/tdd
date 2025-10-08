<?php

declare(strict_types=1);

return function(SQLite3 $db) {
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT UNIQUE,
    password TEXT NOT NULL
);
SQL;

    $db->exec($sql);
};
