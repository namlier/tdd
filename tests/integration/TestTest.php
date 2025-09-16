<?php

declare(strict_types=1);

namespace Tests\Integration;

use Tests\Integration\BaseTestCase;

class TestTest extends BaseTestCase
{
    public function testFirst(): void
    {
        $di = $this->getContainer();
        $std = $di->get('std');

        self::assertInstanceOf(\stdClass::class, $std, 'Tests don\'t work. ')  ;
    }
}