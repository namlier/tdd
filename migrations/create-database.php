<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Dotenv.
 */
(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

/**
 * Dependency Injection.
 */
$containerBuilder = new ContainerBuilder();

$loader = new YamlFileLoader($containerBuilder, new FileLocator(dirname(__DIR__) . '/config'));
$loader->load('services.yaml');
$defintion = $containerBuilder->getDefinition(SQLite3::class);
$defintion->setPublic(true);

$containerBuilder->compile(true);

/**
 * DB.
 */
$db = $containerBuilder->get(SQLite3::class);

$migrations = glob(__DIR__ . '/*'); // TODO: брати тільки .php тільки цієї папки


foreach ($migrations as $migration) {
    if (is_file($migration) && (basename($migration) === 'create-database.php' || basename($migration) === 'delete-database.php')) {
        continue;
    }

    $migration = require_once($migration);
    $migration($db);
}
