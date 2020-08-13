<?php

namespace Enigma\ApplicationServices\Catalog;

use Enigma\ApplicationServices\Catalog\ProductsByUserFinder;
use Enigma\ApplicationServices\Catalog\ProductsByUserFinderQuery;
use Enigma\Auth\Domain\UserEmail;
use Enigma\Catalog\Domain\ProductName;

class ProductsByUserFinderQueryHandler
{
    private ProductsByUserFinder $productsByUserFinder;

    public function __construct(ProductsByUserFinder $productsByUserFinder)
    {
        $this->productsByUserFinder = $productsByUserFinder;
    }

    public function __invoke(ProductsByUserFinderQuery $query)
    {
        $userEmail = new UserEmail($query->getEmail());
        $productName = empty($query->getName()) ? null : new ProductName($query->getName());

        return $this->productsByUserFinder->__invoke($userEmail, $productName);
    }
}
