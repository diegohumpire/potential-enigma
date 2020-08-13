<?php

namespace Enigma\ApplicationServices;

use Enigma\Auth\Domain\Password;
use Enigma\Auth\Domain\Repositories\UserRepository;
use Enigma\Auth\Domain\UserEmail;

class UserCreator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(UserEmail $email, Password $password)
    {
        
    }
}
