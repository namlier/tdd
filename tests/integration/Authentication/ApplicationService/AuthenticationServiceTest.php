<?php

declare(strict_types=1);

namespace Tests\Integration\Authentication\ApplicationService;

use Namlier\TDD\User\Repository\UserRepositoryInterface;
use Namlier\TDD\User\Authentication\Application\AuthenticationService;
use Namlier\TDD\User\Authentication\Application\PasswordHasherInterface;
use Namlier\TDD\User\Entity\User;
use PHPUnit\Framework\Attributes\Depends;
use Tests\Integration\BaseTestCase;

class AuthenticationServiceTest extends BaseTestCase
{
    public function testRegistrationProcessPersistsUserInSystem(): User
    {
        /** @var AuthenticationService $sut */
        $sut = $this->getContainer()
            ->get(AuthenticationService::class);

        $sut->register('johndoe@gmail.com', '123123qQ!Q!');

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->getContainer()
            ->get(UserRepositoryInterface::class);
        $user = $userRepository->get('johndoe@gmail.com');

        self::assertEquals(
            'johndoe@gmail.com',
            $user->getEmail(),
            'User should be persisted in system during registration process.'
        );

        return $user;
    }

    #[Depends('testRegistrationProcessPersistsUserInSystem')]
    public function testRegisteredUserHasIdentifier(User $user): void
    {
        self::assertNotEmpty(
            $user->getId(),
            'User should get identifier in system during registration process.'
        );
    }

    #[Depends('testRegistrationProcessPersistsUserInSystem')]
    public function testRegisteredUserHasNotStoredPlainPassword(User $user): void
    {
        self::assertNotEquals(
            '123123qQ!',
            $user->getPassword(),
            "Password must be stored in a hashed form and never equal to the plain password.")
        ;
    }

    #[Depends('testRegistrationProcessPersistsUserInSystem')]
    public function testRegisteredUserHasHashedPassword(User $user): void
    {
        /** @var PasswordHasherInterface $passwordHasher */
        $passwordHasher = $this->getContainer()
            ->get(PasswordHasherInterface::class);

        self::assertTrue(
            $passwordHasher->doesPasswordLookHashed($user->getPassword()),
            'Password doesn\'t look like hashed.'
        );

        self::assertTrue(
            $passwordHasher->verify('123123qQ!Q!', $user->getPassword())
        );
    }
}
