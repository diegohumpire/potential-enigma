<?php

namespace Enigma\ApplicationServices;

use Enigma\Shared\Bus\Commands\Command;

class UserAuthenticateCommand implements Command
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }
}
