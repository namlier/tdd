<?php


return function(\Namlier\UnitTesting\Sqlite\DB $db) {
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE
);
SQL;

    $db->exec($sql);
};
