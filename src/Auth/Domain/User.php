<?php

namespace Enigma\Auth\Domain;

final class User
{
    private UserEmail $userEmail;
    private ?Password $password = null;
    private ?AuthToken $authToken = null;

    public function __construct(UserEmail $userEmail, ?Password $password) 
    {
        $this->userEmail = $userEmail;
        $this->password = $password;
    }

    public function checkPassword(Password $password) : bool
    {
        if (is_null($this->password)) {
            return false;
        }

        return $this->password->checkPassword($password->value());
    }

    /**
     * @return User
     */
    public function generateAuthToken() : User
    {
        if (is_null($this->authToken)) {
            $this->authToken = new AuthToken();
        }

        $this->authToken->generate();

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword() : ?Password
    {
        return $this->password;
    }

    /**
     * Get the value of authToken
     */ 
    public function getAuthToken() : ?AuthToken
    {
        return $this->authToken;
    }

    /**
     * Set the value of authToken
     *
     * @return self
     */ 
    public function setAuthToken(?AuthToken $authToken)
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * Get the value of userEmail
     */ 
    public function getUserEmail() : UserEmail
    {
        return $this->userEmail;
    }
}
