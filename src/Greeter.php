<?php

declare(strict_types=1);

namespace Namlier\UnitTesting;

final class Greeter
{
    public function greet(?string $greetWord = null): string
    {
        if (isset($greetWord) && mb_strlen($greetWord) > 16) {
            throw new \Exception('Greet word is too long!');
        }

        $greetWord = $greetWord ?? 'World';

        return "Hello {$greetWord}!";
    }
}
