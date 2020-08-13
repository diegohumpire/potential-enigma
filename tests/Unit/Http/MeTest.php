<?php

namespace Tests\Unit\Http;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

class MeTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldGetUserInformation()
    {
        $authToken = Uuid::uuid4();

        factory(User::class)->create([
            'email' => 'no_exist_this_email@mail.com',
            'password' => Hash::make('12345678'),
            'auth_token' => $authToken
        ]);

        $response = $this->getJson('/api/me', [
            'x-auth-token' => $authToken
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'email'
        ]);
    }
}
