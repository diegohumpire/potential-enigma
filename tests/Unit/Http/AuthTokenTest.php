<?php

namespace Tests\Unit\Http;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTokenTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldGetAuthTokenNewUser()
    {
        $response = $this->postJson('/api/auth/token', [
            'email' => 'no_exist_this_email@mail.com',
            'password' => '12345678'
        ]);

        $response->assertStatus(200);
    }

    public function testShouldGetErrorWhenGetAuthToken()
    {
        factory(User::class)->create([
            'email' => 'no_exist_this_email1@mail.com',
            'password' => Hash::make('12345678')
        ]);

        $response = $this->postJson('/api/auth/token', [
            'email' => 'no_exist_this_email1@mail.com',
            'password' => '123456781'
        ]);

        $response->assertStatus(401);
    }

    public function testShouldGetAuthToken()
    {
        factory(User::class)->create([
            'email' => 'no_exist_this_email@mail.com',
            'password' => Hash::make('12345678')
        ]);

        $response = $this->postJson('/api/auth/token', [
            'email' => 'no_exist_this_email@mail.com',
            'password' => '12345678'
        ]);

        $response->assertStatus(200);
    }
}
