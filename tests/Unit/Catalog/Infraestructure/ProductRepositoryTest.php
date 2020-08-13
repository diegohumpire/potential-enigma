<?php

namespace Tests\Unit\Catalog\Infraestructure;

use App\Product;
use App\Supplier;
use Enigma\Catalog\Domain\ProductName;
use Tests\TestCase;
use Enigma\Catalog\Domain\SupplierId;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Enigma\Catalog\Infraestructure\ProductEloquentRepository;

class ProductRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldGetProductsBySupplierId()
    {
        $supplier1 = factory(Supplier::class)->create();
        factory(Product::class)->create([
            'supplier_id' => $supplier1->id,
        ]);
        factory(Product::class)->create([
            'supplier_id' => $supplier1->id,
        ]);

        $productRepository = new ProductEloquentRepository();
        $products = $productRepository->findBySupplierId(new SupplierId($supplier1->id));

        $this->assertNotEmpty($products);
    }

    public function testShouldGetProductsBySupplierIdAndName()
    {
        $supplier1 = factory(Supplier::class)->create();
        factory(Product::class)->create([
            'supplier_id' => $supplier1->id,
            'name' => 'product name random'
        ]);
        factory(Product::class)->create([
            'supplier_id' => $supplier1->id,
        ]);

        $productRepository = new ProductEloquentRepository();
        $products = $productRepository->findBySupplierIdAndName(
            new SupplierId($supplier1->id),
            new ProductName('product name random')
        );

        $this->assertNotEmpty($products);
        $this->assertEquals(count($products), 1);
    }
}
