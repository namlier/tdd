<?php

declare(strict_types=1);

namespace Tests\Integration;

use Namlier\UnitTesting\Sqlite\DB;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class BaseTestCase extends TestCase
{
    private static Container $container;

    private DB $db;

    protected function getContainer(): Container
    {
        if (!isset(self::$container)) {
            $containerBuilder = new ContainerBuilder();

            $loader = new YamlFileLoader($containerBuilder, new FileLocator(dirname(__DIR__, 2) . '/config'));
            $loader->load('services.yaml');

            $containerBuilder->compile(true);

            self::$container = $containerBuilder;
        }

        return self::$container;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->getDB()
            ->query('BEGIN TRANSACTION');
    }

    protected function tearDown(): void
    {
        $this->getDB()
            ->query('ROLLBACK');

        parent::tearDown();
    }

    private function getDB(): DB
    {
        if (!isset($this->db)) {
            $this->db = $this->getContainer()
                ->get(DB::class);
        }

        return $this->db;
    }
}