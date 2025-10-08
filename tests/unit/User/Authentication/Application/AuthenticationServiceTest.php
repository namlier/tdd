<?php

declare(strict_types=1);

namespace User\Authentication\Application;

use Namlier\UnitTesting\User\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Namlier\UnitTesting\User\Authentication\Application\AuthenticationService;
use Namlier\UnitTesting\User\Entity\User;

class AuthenticationServiceTest extends TestCase
{
    public function testRegisterDoesntStoreUsersPlainPassword(): void
    {
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $sut = new AuthenticationService($userRepositoryMock);

        $userRepositoryMock->method('save')
            ->with($this->callback([self::class, 'assertPlainPasswordIsNotGoingToBeStoredInRepository']));

        $sut->register('johndoe@gmail.com', '123123q');
    }

    public static function assertPlainPasswordIsNotGoingToBeStoredInRepository(User $user): bool
    {
        self::assertNotEquals('123123q', $user->getPassword(), 'Plain password must not be stored.');

        return true;
    }
}
