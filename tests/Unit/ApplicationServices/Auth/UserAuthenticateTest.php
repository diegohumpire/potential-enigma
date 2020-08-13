<?php

namespace Tests\Unit\ApplicationServices\Auth;

use Enigma\ApplicationServices\Auth\Exceptions\UnauthorizeUserException;
use Enigma\ApplicationServices\Auth\UserAuthenticate;
use Enigma\ApplicationServices\Auth\UserAuthenticateCommand;
use Enigma\ApplicationServices\Auth\UserAuthenticateCommandHandler;
use Enigma\Auth\Infraestructure\Eloquent\UserEloquentRepository;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAuthenticateTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldThrowErrorPassword()
    {
        $emailMock = 'dhlogin@logintest.com';
        $password = Hash::make('123456');

        $userMock = factory(\App\User::class)->create([
            'email' => $emailMock,
            'password' => $password
        ]);

        $userRepository = $this->app->make(UserEloquentRepository::class);

        $authenticateCommand = new UserAuthenticateCommand($emailMock, '1234561');
        $authenticateCommandHandler = new UserAuthenticateCommandHandler(new UserAuthenticate($userRepository));

        $this->expectException(UnauthorizeUserException::class);
        $this->expectExceptionMessage("Oops! wrong password");

        $authenticateCommandHandler($authenticateCommand);
    }

    public function testShouldCreateAuthToken()
    {
        $emailMock = 'dhlogin@logintest.com';
        $password = Hash::make('123456');

        $userMock = factory(\App\User::class)->create([
            'email' => $emailMock,
            'password' => $password
        ]);

        $userRepository = $this->app->make(UserEloquentRepository::class);

        $authenticateCommand = new UserAuthenticateCommand($emailMock, '123456');
        $authenticateCommandHandler = new UserAuthenticateCommandHandler(new UserAuthenticate($userRepository));

        $user = $authenticateCommandHandler($authenticateCommand);

        $this->assertDatabaseHas('users', [
            'auth_token' => $user->getAuthToken()->value(),
            'email' => $user->getUserEmail()->value(),
            'password' => $user->getPassword()->value()
        ]);
    }

    public function testShouldCreateUserIfNotExist()
    {
        $emailMock = 'dhlogin_non_exist@logintest.com';
        $password = '123456';

        $userRepository = $this->app->make(UserEloquentRepository::class);

        $authenticateCommand = new UserAuthenticateCommand($emailMock, $password);
        $authenticateCommandHandler = new UserAuthenticateCommandHandler(new UserAuthenticate($userRepository));

        $user = $authenticateCommandHandler($authenticateCommand);

        $this->assertDatabaseHas('users', [
            'auth_token' => $user->getAuthToken()->value(),
            'email' => $emailMock,
            'password' => $user->getPassword()->value()
        ]);
    }
}
