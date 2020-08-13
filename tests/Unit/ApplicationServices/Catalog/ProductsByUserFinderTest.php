<?php

namespace Tests\Unit\ApplicationServices\Catalog;

use App\Product;
use App\Supplier;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Enigma\ApplicationServices\Catalog\ProductsByUserFinder;
use Enigma\Catalog\Infraestructure\ProductEloquentRepository;
use Enigma\Auth\Infraestructure\Eloquent\UserEloquentRepository;
use Enigma\ApplicationServices\Catalog\ProductsByUserFinderQueryHandler;
use Enigma\ApplicationServices\Catalog\ProductsByUserFinderQuery;
use Enigma\Catalog\Domain\ProductName;

class ProductsByUserFinderTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldGetProductsByUser()
    {
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
            'supplier_id' => $supplier1->id
        ]);

        $query = new ProductsByUserFinderQuery($emailMock);

        $service = new ProductsByUserFinder(new ProductEloquentRepository(), new UserEloquentRepository());
        $queryHandler = new ProductsByUserFinderQueryHandler($service);
        $products = $queryHandler($query);

        $this->assertTrue(count($products) === 2);
    }

    public function testShouldGetProductsByUserAndName()
    {
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
            'supplier_id' => $supplier1->id
        ]);

        $query = new ProductsByUserFinderQuery($emailMock, new ProductName('a'));

        $service = new ProductsByUserFinder(new ProductEloquentRepository(), new UserEloquentRepository());
        $queryHandler = new ProductsByUserFinderQueryHandler($service);
        $products = $queryHandler($query);

        $this->assertTrue(count($products) === 1);
    }
}
