<?php

namespace Enigma\Catalog\Domain;

class Supplier
{
    private SupplierName $supplierName;
    private SupplierId $supplierId;

    /**
     * Get the value of supplierName
     */ 
    public function getSupplierName() : SupplierName
    {
        return $this->supplierName;
    }

    /**
     * Get the value of supplierId
     */ 
    public function getSupplierId() : SupplierId
    {
        return $this->supplierId;
    }
}
