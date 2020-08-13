<?php

namespace Enigma\ApplicationServices\Catalog;

use Enigma\Auth\Domain\Repositories\UserRepository;
use Enigma\Auth\Domain\UserEmail;
use Enigma\Catalog\Domain\ProductName;
use Enigma\Catalog\Domain\Repositories\ProductRepository;

class ProductsByUserFinder
{
    private UserRepository $userRepository;
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(UserEmail $userEmail, ?ProductName $productName = null)
    {
        $user = $this->userRepository->findByEmail($userEmail);

        if (empty($user)) {
            return [];
        }

        if (!empty($productName)) {
            return $this->productRepository->findBySupplierIdAndName($user->getSupplierId(), $productName);
        }

        return $this->productRepository->findBySupplierId($user->getSupplierId());
    }
}
