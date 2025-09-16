<?php

declare(strict_types=1);

namespace Tests\Integration;

use Tests\Integration\BaseTestCase;

class AnotherTest extends BaseTestCase
{
    public function testAnotherOne(): void
    {
        $std = $this->getContainer()->get('std');

        self::assertInstanceOf(\stdClass::class, $std);
    }
}
