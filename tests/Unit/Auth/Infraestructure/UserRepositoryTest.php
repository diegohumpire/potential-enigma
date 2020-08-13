<?php

namespace Tests\Unit\Auth\Infraestructure;

use Enigma\Auth\Domain\User;
use Enigma\Auth\Domain\UserEmail;
use Enigma\Auth\Infraestructure\Eloquent\UserEloquentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldGetUserDomain()
    {
        $passwordMock = Hash::make('123456');
        $userMock = factory(\App\User::class)->create([
            'email' => 'dh@testingmail.com',
            'password' => $passwordMock
        ]);

        $userRepository = new UserEloquentRepository();
        $userResult = $userRepository->findByEmail(new UserEmail('dh@testingmail.com'));

        $this->assertNotNull($userResult);
        $this->assertTrue($userResult instanceof User);
        $this->assertEquals($userResult->getPassword()->value(), $passwordMock);
    }
}
