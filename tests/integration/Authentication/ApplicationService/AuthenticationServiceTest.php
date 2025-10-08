<?php

declare(strict_types=1);

namespace Tests\Integration\Authentication\ApplicationService;

use Namlier\UnitTesting\User\Authentication\Application\AuthenticationService;
use Namlier\UnitTesting\User\Repository\UserRepository;
use Tests\Integration\BaseTestCase;

class AuthenticationServiceTest extends BaseTestCase
{
    public function testRegistrationProcessPersistsUserInSystemAndAssignsIdentifier(): void
    {
        /** @var AuthenticationService $sut */
        $sut = $this->getContainer()
            ->get(AuthenticationService::class);

        $sut->register('johndoe@gmail.com', '123123q');

        /** @var UserRepository $userRepository */
        $userRepository = $this->getContainer()
            ->get(UserRepository::class);
        $user = $userRepository->get('johndoe@gmail.com');

        self::assertNotNull(
            $user->getId(),
            'User should be persisted in system and should have identifier after registration process'
        );
    }
}
