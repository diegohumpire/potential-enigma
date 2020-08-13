<?php

namespace Enigma\Shared\Domain\ValueObject;

class IntegerValueObject
{
    private int $value = 0;

    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value();
    }
}
