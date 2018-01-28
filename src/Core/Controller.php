<?php

namespace App\Core;

use App\Psr\Container\ContainerInterface;

abstract class Controller
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}