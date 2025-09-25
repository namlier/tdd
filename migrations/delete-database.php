<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Dotenv.
 */
(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');




$dbName = $_ENV['SQLITE_FILENAME'];

if (file_exists(dirname(__DIR__) . '/' . $dbName)) {
    $yesno = readline("WARNING! The existing database will be deleted. Are you sure you want to delete {$dbName}? Y/n: ");

    if ($yesno !== 'Y') {
        exit('Database creation terminated.');
    }

    unlink(dirname(__DIR__) . '/' . $dbName);
}