<?php

namespace Enigma\Catalog\Infraestructure;

use Enigma\Catalog\Domain\Product;
use App\Product as ProductEloquent;
use Enigma\Catalog\Domain\ProductId;
use Enigma\Catalog\Domain\SupplierId;
use Enigma\Catalog\Domain\ProductName;
use Enigma\Catalog\Domain\ProductPrice;
use Enigma\Catalog\Domain\ProductIsActive;
use Enigma\Catalog\Domain\Repositories\ProductRepository;

class ProductEloquentRepository implements ProductRepository
{
    public function findBySupplierId(SupplierId $supplierId) : array
    {
        $productsFormEloquent = ProductEloquent::where('supplier_id', $supplierId->value())->get();
        $products = [];

        foreach ($productsFormEloquent as $product) {
            $productName = new ProductName($product->name);
            $productPrice = new ProductPrice($product->price);
            $productIsActive = new ProductIsActive($product->is_active);

            $productDomain = new Product(
                $productName,
                $productPrice,
                $productIsActive,
                $supplierId
            );
            $productDomain->setProductId(new ProductId($product->id));

            $products[] = $productDomain;
        }

        return $products;
    }

    public function findBySupplierIdAndName(SupplierId $supplierId, ProductName $productName) : array
    {
        $productsFormEloquent = ProductEloquent::where('supplier_id', $supplierId->value())
            ->where('name', 'LIKE', "%{$productName}%")
            ->get();
        $products = [];

        foreach ($productsFormEloquent as $product) {
            $productName = new ProductName($product->name);
            $productPrice = new ProductPrice($product->price);
            $productIsActive = new ProductIsActive($product->is_active);

            $productDomain = new Product(
                $productName,
                $productPrice,
                $productIsActive,
                $supplierId
            );
            $productDomain->setProductId(new ProductId($product->id));

            $products[] = $productDomain;
        }

        return $products;
    }
}
