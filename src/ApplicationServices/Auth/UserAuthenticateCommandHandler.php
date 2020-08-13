<?php

namespace Enigma\ApplicationServices\Auth;

use Enigma\Auth\Domain\Password;
use Enigma\Auth\Domain\UserEmail;
use Enigma\Auth\Domain\User;

/**
 * @method User userAuthenticate($userEmail, $password)
 */
class UserAuthenticateCommandHandler
{
    /**
     * @var \Closure
     */
    private UserAuthenticate $userAuthenticate;

    public function __construct(UserAuthenticate $userAuthenticate)
    {
        $this->userAuthenticate = $userAuthenticate;
    }

    /**
     * @param UserAuthenticateCommand $userAuthenticateCommand
     * @return User
     */
    public function __invoke(UserAuthenticateCommand $userAuthenticateCommand)
    {
        $userEmail = new UserEmail($userAuthenticateCommand->getEmail());
        $password = new Password($userAuthenticateCommand->getPassword());

        return $this->userAuthenticate->__invoke($userEmail, $password);
    }
}
