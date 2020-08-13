<?php

namespace Enigma\Auth\Domain;

use Enigma\Shared\Domain\ValueObject\StringValueObject;
use Ramsey\Uuid\Uuid;

class AuthToken extends StringValueObject
{
    public function generate()
    {
        $this->value = (string) Uuid::uuid4();

        return $this;
    }
}
