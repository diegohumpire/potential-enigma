<?php

namespace Enigma\ApplicationServices\Catalog;

use Enigma\Shared\Bus\Query\Query;

class ProductsByUserFinderQuery extends Query
{
    private string $email;
    private ?string $name;

    public function __construct(string $email, ?string $name = null)
    {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Get the value of name
     */ 
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail() : string
    {
        return $this->email;
    }
}
