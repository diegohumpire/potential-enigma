<?php

namespace Enigma\ApplicationServices\Auth;

use Enigma\ApplicationServices\Auth\Exceptions\UnauthorizeUserException;
use Enigma\Auth\Domain\AuthToken;
use Enigma\Auth\Domain\Repositories\UserRepository;

class UserFinderByAuthToken
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(AuthToken $authToken)
    {
        $user = $this->userRepository->findByAuthToken($authToken);

        if (empty($user)) {
            throw new UnauthorizeUserException("Invalid token!");
        }

        return $user;
    }
}
