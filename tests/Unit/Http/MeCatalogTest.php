<?php

namespace Tests\Unit\Http;

use App\Product;
use App\Supplier;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

class MeCatalogTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldGetCatalog()
    {
        $authToken = Uuid::uuid4();

        $supplier1 = factory(Supplier::class)->create();
        factory(Product::class)->create([
            'supplier_id' => $supplier1->id,
            'name' => 'a'
        ]);
        factory(Product::class)->create([
            'supplier_id' => $supplier1->id,
            'name' => 'b'
        ]);

        $emailMock = 'dhlogin@logintest.com';
        $password = Hash::make('123456');

        $userMock = factory(\App\User::class)->create([
            'email' => $emailMock,
            'password' => $password,
            'supplier_id' => $supplier1->id,
            'auth_token' => $authToken
        ]);

        $response = $this->getJson('/api/me/products', [
            'x-auth-token' => $authToken
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data'
        ]);

        $jsonDecode = json_decode($response->baseResponse->content());
        
        $this->assertTrue(count($jsonDecode->data) === 2);
    }
}
