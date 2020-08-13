<?php

namespace Enigma\ApplicationServices\Catalog;

use Enigma\Auth\Domain\UserEmail;

class SupplierAssociateToUserCommandHandler
{
    private SupplierAssociateToUser $supplierAssociateToUser;

    public function __construct(SupplierAssociateToUser $supplierAssociateToUser)
    {
        $this->supplierAssociateToUser = $supplierAssociateToUser;
    }

    public function __invoke(SupplierAssociateToUserCommand $command)
    {
        $userEmail = new UserEmail($command->getUserEmail());

        $this->supplierAssociateToUser->__invoke($userEmail);
    }
}
