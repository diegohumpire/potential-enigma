<?php

namespace Enigma\Auth\Domain\Repositories;

use Enigma\Auth\Domain\User;
use Enigma\Auth\Domain\AuthToken;
use Enigma\Auth\Domain\UserEmail;

interface UserRepository
{
    public function findByEmail(UserEmail $userEmail) : ?User;

    public function findByAuthToken(AuthToken $authToken): ?User;

    public function save(User $user) : User;
}
