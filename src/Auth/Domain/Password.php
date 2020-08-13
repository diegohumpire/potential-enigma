<?php

namespace Enigma\Auth\Domain;

use Enigma\Shared\Domain\ValueObject\StringValueObject;
use Illuminate\Support\Facades\Hash;

class Password extends StringValueObject
{
    protected bool $hashed;

    public function __construct(string $value, bool $hashed = false)
    {
        $this->value = $value;
        $this->hashed = $hashed;
    }

    public function hashPassword() : Password
    {
        if (!$this->hashed) {
            $this->value = Hash::make($this->value);
            $this->hashed = true;
        }

        return $this;
    }

    public function checkPassword(string $plainPassword) : bool
    {
        return Hash::check($plainPassword, $this->value);
    }

    /**
     * @param bool $hashed
     * @return Password
     */
    public function setHashed(bool $hashed)
    {
        $this->hashed = $hashed;

        return $this;
    }
}