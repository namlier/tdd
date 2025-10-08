<?php

declare(strict_types=1);

namespace Tests\Integration\Authentication\ApplicationService;

use Namlier\UnitTesting\User\Authentication\Application\AuthenticationService;
use Namlier\UnitTesting\User\Entity\User;
use Namlier\UnitTesting\User\Repository\UserRepository;
use PHPUnit\Framework\Attributes\Depends;
use Tests\Integration\BaseTestCase;

class AuthenticationServiceTest extends BaseTestCase
{
    public function testRegistrationProcessPersistsUserInSystem(): User
    {
        /** @var AuthenticationService $sut */
        $sut = $this->getContainer()
            ->get(AuthenticationService::class);

        $sut->register('johndoe@gmail.com', '123123q');

        /** @var UserRepository $userRepository */
        $userRepository = $this->getContainer()
            ->get(UserRepository::class);
        $user = $userRepository->get('johndoe@gmail.com');

        self::assertEquals(
            'johndoe@gmail.com',
            $user->getEmail(),
            'User should be persisted in system during registration process.'
        );

        return $user;
    }

    #[Depends('testRegistrationProcessPersistsUserInSystem')]
    public function testRegistrationProcessAssignsIdToNewUser(User $user): void
    {
        self::assertNotEmpty(
            $user->getId(),
            'User should get identifier in system during registration process.'
        );
    }
}
