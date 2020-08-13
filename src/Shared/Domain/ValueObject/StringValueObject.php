<?php

namespace Enigma\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    protected ?string $value = "";

    /**
     * @param string $value
     */
    public function __construct(?string $value = "")
    {
        $this->value = $value;
    }

    public function value() : ?string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }
}
