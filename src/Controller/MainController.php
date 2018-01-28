<?php

namespace App\Controller;

use App\Core\Controller;
use App\Service\Crypto\PasswordEncryptorInterface;
use App\Service\Test\TestInterface;

class MainController extends Controller
{

    public function notFoundAction()
    {
        return "<h1>PAGE NOT FOUND!</h1>";
    }

    public function indexAction(PasswordEncryptorInterface $encryptor, TestInterface $test)
    {
        $test->run();
        return "<br />hash: " . $encryptor->encrypt("XXX");
    }
}