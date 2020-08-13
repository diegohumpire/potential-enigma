<?php

namespace Enigma\Catalog\Domain\Repositories;

use Enigma\Catalog\Domain\Supplier;
use Enigma\Catalog\Domain\SupplierId;

interface SupplierRepository
{
    public function findById(SupplierId $supplierId) : ?Supplier;

    public function getRandom() : ?Supplier;
}
