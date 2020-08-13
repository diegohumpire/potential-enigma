<?php

namespace Enigma\ApplicationServices\Auth;

use Enigma\Auth\Domain\AuthToken;

class UserFinderByAuthTokenQueryHandler
{
    private UserFinderByAuthToken $service;

    public function __construct(UserFinderByAuthToken $service)
    {
        $this->service = $service;
    }

    public function __invoke(UserFinderByAuthTokenQuery $query)
    {
        $authToken = new AuthToken($query->getAuthToken());

        return $this->service->__invoke($authToken);
    }
}
