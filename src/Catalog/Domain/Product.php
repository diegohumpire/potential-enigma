<?php

namespace Enigma\Catalog\Domain;

use Enigma\Shared\Domain\Aggregates\AggregateRoot;

class Product extends AggregateRoot
{
    private ProductId $productId;
    private ProductName $productName;
    private ProductPrice $productPrice;
    private ProductIsActive $productIsActive;
    private SupplierId $supplierId;
    private Supplier $supplier;

    public function __construct(
        ProductName $productName, 
        ProductPrice $productPrice,
        ProductIsActive $productIsActive,
        SupplierId $supplierId
    ) {
        $this->productName = $productName;
        $this->productPrice = $productPrice;
        $this->productIsActive = $productIsActive;
        $this->supplierId = $supplierId;
    }

    /**
     * Get the value of productId
     */ 
    public function getProductId() : ProductId
    {
        return $this->productId;
    }

    /**
     * Set the value of productId
     *
     * @return  self
     */
    public function setProductId(ProductId $productId) : Product
    {
        $this->productId = $productId;

        return $this;
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
