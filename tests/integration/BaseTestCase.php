<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BaseTestCase extends TestCase
{
    private static Container $container;

    protected function getContainer(): Container
    {
        if (!isset(self::$container)) {
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->register('std', \stdClass::class)->setPublic(true);
            $containerBuilder->compile();

            self::$container = $containerBuilder;
        }

        return self::$container;
    }

    protected function setUp(): void
    {
        parent::setUp();

        // TODO: відкрити транзакцію
    }

    protected function tearDown(): void
    {
        // TODO: закрити транзакцію

        parent::tearDown();
    }
}