<?php

declare(strict_types=1);

namespace Namlier\TDD\Common;

use Namlier\TDD\User\Authentication\Application\PasswordValidatorInterface;

class PasswordValidator implements PasswordValidatorInterface
{
    private const string SPECIAL_SYMBOLS = '!@#$%^&*()';

    public function ensureValid(string $password): void
    {
        $message = '';
        $hasError = false;

        if (mb_strlen($password) < 8) {
            $hasError = true;
            $message.= 'Password should contain at least 8 symbols.';
        }

        if (preg_match('/[A-Z]/', $password) !== 1) {
            $hasError = true;
            $message.= 'Password should contain at least one uppercase character.';
        }

        if (preg_match('/[a-z]/', $password) !== 1) {
            $hasError = true;
            $message.= 'Password should contain at least one lowercase character.';
        }

        if (preg_match('/\d/', $password) !== 1) {
            $hasError = true;
            $message.= 'Password should contain at least one number.';
        }

        if (preg_match('/[!@#$%^&*()]/', $password) !== 1) {
            $hasError = true;
            $message.= 'Password should contain at least one special symbol from list "' . self::SPECIAL_SYMBOLS . '".';
        }

        if ($hasError) {
            throw new \Exception($message);
        }
    }
}