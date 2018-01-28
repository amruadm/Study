<?php

namespace App\Service\Crypto;

class MD5Encryptor implements PasswordEncryptorInterface
{

    /**
     * @param string $pass
     * @return string
     */
    public function encrypt(string $pass)
    {
        return hash('md5', $pass);
    }
}