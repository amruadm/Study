<?php

namespace App\Service\Crypto;

class SHA1Encryptor implements PasswordEncryptorInterface
{

    /**
     * @param string $pass
     * @return string
     */
    public function encrypt(string $pass)
    {
        return hash('sha1', $pass);
    }
}