<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SQLite3;

class BaseTestCase extends TestCase
{
    private static Container $container;

    private SQLite3 $db;

    protected function getContainer(): Container
    {
        if (!isset(self::$container)) {
            $containerBuilder = new ContainerBuilder();

            $loader = new YamlFileLoader($containerBuilder, new FileLocator(dirname(__DIR__, 2) . '/config'));
            $loader->load('services.yaml');

            foreach ($containerBuilder->getDefinitions() as $definition) {
                if ($definition->getClass() === ContainerInterface::class) {
                    continue;
                }

                $definition->setPublic(true);
            }

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

    private function getDB(): SQLite3
    {
        if (!isset($this->db)) {
            $this->db = $this->getContainer()
                ->get(SQLite3::class);
        }

        return $this->db;
    }
}