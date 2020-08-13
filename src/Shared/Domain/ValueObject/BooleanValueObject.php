<?php

namespace Enigma\Shared\Domain\ValueObject;

class BooleanValueObject
{
    private bool $value = false;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function value(): bool
    {
        return $this->value;
    }
}
