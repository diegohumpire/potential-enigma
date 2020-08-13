<?php

namespace Enigma\ApplicationServices\Auth;

use Enigma\Auth\Domain\Password;
use Enigma\Auth\Domain\UserEmail;

class UserCreatorCommandHandler
{
    private UserCreator $userCreator;

    public function __construct(UserCreator $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    public function __invoke(UserCreatorCommand $userCreatorCommand)
    {
        $userEmail = new UserEmail($userCreatorCommand->getEmail());
        $password = new Password($userCreatorCommand->getPassword());

        return $this->userCreator->__invoke($userEmail, $password);
    }
}
