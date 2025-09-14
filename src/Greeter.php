<?php

declare(strict_types=1);

namespace Namlier\UnitTesting;

final class Greeter
{
    public function greet(?string $greetWord = null): string
    {
        $this->ensureWordLength($greetWord);

        $greetWord = $greetWord ?? 'World';

        return "Hello {$greetWord}!";
    }

    private function ensureWordLength(?string $greetWord = null): void
    {
        if (isset($greetWord) && mb_strlen($greetWord) > 16) {
            throw new \Exception('Greet word is too long!');
        }
    }
}
