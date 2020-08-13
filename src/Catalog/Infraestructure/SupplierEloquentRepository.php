<?php

namespace Enigma\Catalog\Infraestructure;

use Enigma\Catalog\Domain\Supplier;
use App\Supplier as SupplierEloquent;
use Enigma\Catalog\Domain\SupplierId;
use Enigma\Catalog\Domain\Repositories\SupplierRepository;
use Enigma\Catalog\Domain\SupplierName;

class SupplierEloquentRepository implements SupplierRepository
{
    public function findById(SupplierId $supplierId) : ?Supplier
    {
        $supplierEloquentInstance = SupplierEloquent::where('id', $supplierId->value())->first();

        if (empty($supplierEloquentInstance)) {
            return null;
        } 

        $supplierName = new SupplierName($supplierEloquentInstance->name);

        return new Supplier($supplierId, $supplierName);
    }

    public function getRandom() : ?Supplier
    {
        $supplierEloquentInstance = SupplierEloquent::query()->inRandomOrder()->first();

        if (empty($supplierEloquentInstance)) {
            return null;
        }

        $supplierId = new SupplierId($supplierEloquentInstance->id);
        $supplierName = new SupplierName($supplierEloquentInstance->name);

        return new Supplier($supplierId, $supplierName);
    }
}
