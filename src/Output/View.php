<?php

declare(strict_types=1);

namespace Namlier\TDD\Output;


class View
{
    public function render(string $mainTag = 'h1'): void
    {
        echo "<{$mainTag}>Welcome</{$mainTag}>";
    }
}