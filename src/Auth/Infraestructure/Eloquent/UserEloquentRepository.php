<?php

namespace Enigma\Auth\Infraestructure\Eloquent;

use App\User as EloquentUser;
use Enigma\Auth\Domain\AuthToken;
use Enigma\Auth\Domain\Password;
use Enigma\Auth\Domain\Repositories\UserRepository;
use Enigma\Auth\Domain\UserEmail;
use Enigma\Auth\Domain\User;

class UserEloquentRepository implements UserRepository
{
    public function findByEmail(UserEmail $userEmail): ?User
    {
        $userEloquent = EloquentUser::where('email', $userEmail->value())->first();

        if (empty($userEloquent)) {
            return null;
        }

        $user = new User($userEmail, new Password($userEloquent->password));

        // Set AuthToken
        $user->setAuthToken(new AuthToken($userEloquent->auth_token));

        return $user;
    }

    public function save(User $user) : User
    {
        $userEloquent = EloquentUser::where('email', $user->getUserEmail()->value())->first();

        if (is_null($userEloquent)) {
            $userEloquent = new EloquentUser();
            $userEloquent->password = $user->getPassword()->hashPassword()->value();
        }

        $userEloquent->email = $user->getUserEmail()->value();
        $userEloquent->auth_token = $user->getAuthToken()->value();
        $userEloquent->save();

        return $user;
    }
}
