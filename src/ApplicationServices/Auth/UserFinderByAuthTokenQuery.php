<?php

namespace Enigma\ApplicationServices\Auth;

use Enigma\Shared\Bus\Query\Query;

class UserFinderByAuthTokenQuery extends Query
{
    private string $authToken;

    public function __construct(string $authToken)
    {
        $this->authToken = $authToken;
    }

    /**
     * Get the value of authToken
     */ 
    public function getAuthToken()
    {
        return $this->authToken;
    }
}
