<?php

namespace Enigma\Catalog\Domain;

use Enigma\Shared\Domain\Aggregates\AggregateRoot;

class Product extends AggregateRoot
{
    private ProductId $productId;
    private SupplierId $supplierId;
    private Supplier $supplier;
    private ProductName $productName;
    private ProductPrice $productPrice;
    private ProductIsActive $productIsActive;

    /**
     * Get the value of productId
     */ 
    public function getProductId() : ProductId
    {
        return $this->productId;
    }

    /**
     * Get the value of supplierId
     */ 
    public function getSupplierId() : SupplierId
    {
        return $this->supplierId;
    }

    /**
     * Get the value of supplier
     */ 
    public function getSupplier() : Supplier
    {
        return $this->supplier;
    }

    /**
     * Get the value of productName
     */ 
    public function getProductName() : ProductName
    {
        return $this->productName;
    }

    /**
     * Get the value of productPrice
     */ 
    public function getProductPrice() : ProductPrice
    {
        return $this->productPrice;
    }

    /**
     * Get the value of productIsActive
     */ 
    public function getProductIsActive() : ProductIsActive
    {
        return $this->productIsActive;
    }
}
