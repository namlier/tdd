<?php

declare(strict_types=1);

return function(SQLite3 $db) {
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE
);
SQL;

    $db->exec($sql);
};
