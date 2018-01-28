<?php

namespace App\Core;

use App\Psr\Container\ContainerInterface;

abstract class Controller
{
    private $container;

    public function setupContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public abstract function action();
}