<?php

namespace Enigma\ApplicationServices;

use Enigma\ApplicationServices\Exceptions\UnauthorizeUserException;
use Enigma\Auth\Domain\Password;
use Enigma\Auth\Domain\Repositories\UserRepository;
use Enigma\Auth\Domain\User;
use Enigma\Auth\Domain\UserEmail;
use Enigma\Shared\Bus\Commands\Command;

class UserAuthenticate
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(UserEmail $userEmail, Password $password)
    {
        $user = $this->userRepository->findByEmail($userEmail);

        if (empty($user)) {
            $newUser = new User($userEmail, $password);
            $newUser->getPassword()->hashPassword();
            $newUser->generateAuthToken();

            $this->userRepository->save($newUser);

            return $newUser;
        }

        if ($user->checkPassword($password)) {

            // Generate new Auth Token
            $user->generateAuthToken();

            $this->userRepository->save($user);

            return $user;
        }

        throw new UnauthorizeUserException("Oops! wrong password");
    }
}
