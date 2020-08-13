<?php

namespace Tests\Unit\ApplicationServices\Auth;

use App\Supplier;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Enigma\ApplicationServices\Auth\UserAuthenticate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Enigma\ApplicationServices\Auth\UserAuthenticateCommand;
use Enigma\Auth\Infraestructure\Eloquent\UserEloquentRepository;
use Enigma\ApplicationServices\Auth\UserAuthenticateCommandHandler;
use Enigma\ApplicationServices\Auth\Exceptions\UnauthorizeUserException;

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

        factory(Supplier::class)->create();

        $userRepository = $this->app->make(UserEloquentRepository::class);

        $authenticateCommand = new UserAuthenticateCommand($emailMock, $password);
        $authenticateCommandHandler = new UserAuthenticateCommandHandler(new UserAuthenticate($userRepository));

        $user = $authenticateCommandHandler($authenticateCommand);

        $this->assertDatabaseHas('users', [
            'auth_token' => $user->getAuthToken()->value(),
            'email' => $emailMock,
            'password' => $user->getPassword()->value(),
            'supplier_id' => $user->getSupplierId()->value()
        ]);
    }
}
