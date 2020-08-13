<?php

namespace Enigma\ApplicationServices\Auth;

use Enigma\ApplicationServices\Auth\Exceptions\UnauthorizeUserException;
use Enigma\Auth\Domain\Password;
use Enigma\Auth\Domain\Repositories\UserRepository;
use Enigma\Auth\Domain\User;
use Enigma\Auth\Domain\UserEmail;

class UserAuthenticate
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return User
     */
    public function __invoke(UserEmail $userEmail, Password $password)
    {
        $user = $this->userRepository->findByEmail($userEmail);

        if (empty($user)) {
            $newUserCommandHandler = new UserCreatorCommandHandler(new UserCreator($this->userRepository));
        
            return $newUserCommandHandler(new UserCreatorCommand($userEmail->value(), $password->value()));
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
