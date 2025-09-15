<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\Output;


class View
{
    public function render(): void
    {
        echo '<h1>Welcome</h1>';
    }
}