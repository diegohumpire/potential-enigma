<?php

namespace Enigma\Auth\Domain\Repositories;

use Enigma\Auth\Domain\User;
use Enigma\Auth\Domain\UserEmail;

interface UserRepository
{
    public function findByEmail(UserEmail $userEmail) : ?User;

    public function save(User $user) : User;
}
