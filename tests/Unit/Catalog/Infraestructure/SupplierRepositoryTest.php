<?php

namespace Tests\Unit\Catalog\Infraestructure;

use App\Supplier;
use Enigma\Catalog\Domain\Supplier as DomainSupplier;
use Enigma\Catalog\Infraestructure\SupplierEloquentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SupplierRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldGetRandomSupplier()
    {
        factory(Supplier::class)->create();

        $supplierRepository = new SupplierEloquentRepository();
        $supplier = $supplierRepository->getRandom();

        $this->assertNotNull($supplier);
        $this->assertTrue($supplier instanceof DomainSupplier);
    }
}
