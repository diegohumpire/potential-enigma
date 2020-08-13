<?php

namespace Enigma\Catalog\Domain\Repositories;

use Enigma\Catalog\Domain\SupplierId;
use Enigma\Catalog\Domain\ProductName;

interface ProductRepository
{
    public function findBySupplierId(SupplierId $supplierId): array;

    public function findBySupplierIdAndName(SupplierId $supplierId, ProductName $productName): array;
}
