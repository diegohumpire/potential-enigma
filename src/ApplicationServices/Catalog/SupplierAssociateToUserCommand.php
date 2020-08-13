<?php

namespace Enigma\ApplicationServices\Catalog;

use Enigma\Shared\Bus\Commands\Command;

class SupplierAssociateToUserCommand implements Command
{
    private string $userEmail;

    public function __construct(string $userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * Get the value of userEmail
     */ 
    public function getUserEmail() : string
    {
        return $this->userEmail;
    }
}
