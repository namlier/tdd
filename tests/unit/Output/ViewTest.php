<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Namlier\TDD\Output\View;

class ViewTest extends TestCase
{
    public function testRender(): void
    {
        $sut = new View();

        $sut->render();

        self::expectOutputString('<h1>Welcome</h1>');
    }

    public function testRenderWithDifferentTag(): void
    {
        // When you are working on a new test case class, you might want to begin by writing empty test methods
        // so mark them as  incomplete
        $this->markTestIncomplete();
    }
}