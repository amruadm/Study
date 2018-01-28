<?php

namespace App\Service\Crypto;

interface PasswordEncryptorInterface
{
    /**
     * @param string $pass
     * @return string
     */
    public function encrypt(string $pass);
}