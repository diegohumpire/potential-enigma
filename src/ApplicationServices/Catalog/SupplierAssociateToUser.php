<?php

namespace Enigma\ApplicationServices\Catalog;

use Enigma\Auth\Domain\Repositories\UserRepository;
use Enigma\Auth\Domain\UserEmail;
use Enigma\Catalog\Domain\Repositories\SupplierRepository;
use Enigma\Catalog\Domain\SupplierId;
use RuntimeException;

class SupplierAssociateToUser
{
    private UserRepository $userRepository;
    private SupplierRepository $supplierRepository;

    public function __construct(
        UserRepository $userRepository, 
        SupplierRepository $supplierRepository
    ) {
        $this->userRepository = $userRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function __invoke(UserEmail $userEmail)
    {
        $user = $this->userRepository->findByEmail($userEmail);

        if (!empty($user)) {
            $supplierRandom = $this->supplierRepository->getRandom();
            $user->setSupplierId($supplierRandom->getSupplierId());

            $this->userRepository->save($user);
        }
    }
}
