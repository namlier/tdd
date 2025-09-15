<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Namlier\UnitTesting\Output\View;

class ViewTest extends TestCase
{
    public function testRender(): void
    {
        $sut = new View();

        $sut->render();

        self::expectOutputString('<h1>Welcome</h1>');
    }
}