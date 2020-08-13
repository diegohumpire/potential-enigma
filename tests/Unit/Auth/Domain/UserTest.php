<?php

namespace Tests\Unit\Auth\Domain;

use Enigma\Auth\Domain\Password;
use Enigma\Auth\Domain\User;
use Enigma\Auth\Domain\UserEmail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShouldCheckPasswordSuccess()
    {
        $userMock = factory(\App\User::class)->create([
            'password' => Hash::make('123456')
        ]);

        $userEmail = new UserEmail($userMock->email);
        $password = new Password($userMock->password, true);

        $userDomain = new User($userEmail, $password);
        $pass = $userDomain->checkPassword(new Password('123456'));

        $this->assertTrue($pass);
    }
}
