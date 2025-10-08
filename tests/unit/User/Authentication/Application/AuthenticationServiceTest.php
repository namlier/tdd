<?php

declare(strict_types=1);

namespace User\Authentication\Application;

use Namlier\TDD\User\Authentication\Application\PasswordHasherInterface;
use Namlier\TDD\User\Authentication\Application\PasswordValidatorInterface;
use Namlier\TDD\User\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Namlier\TDD\User\Authentication\Application\AuthenticationService;
use Namlier\TDD\User\Entity\User;

class AuthenticationServiceTest extends TestCase
{
    public function testRegisterDoesntStoreUsersPlainPassword(): void
    {
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $passwordHasherStub = $this->createStub(PasswordHasherInterface::class);
        $passwordValidatorStub = $this->createStub(PasswordValidatorInterface::class);
        $sut = new AuthenticationService($userRepositoryMock, $passwordHasherStub, $passwordValidatorStub);

        $userRepositoryMock->method('save')
            ->with($this->callback([self::class, 'assertPlainPasswordIsNotGoingToBeStoredInRepository']));

        $sut->register('johndoe@gmail.com', '123123qQ!');
    }

    public static function assertPlainPasswordIsNotGoingToBeStoredInRepository(User $user): bool
    {
        self::assertNotEquals('123123qQ!', $user->getPassword(), 'Plain password must not be stored.');

        return true;
    }
}
