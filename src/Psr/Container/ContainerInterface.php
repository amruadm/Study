<?php

/**
 * PSR-11
 */

namespace App\Psr\Container;

/**
 * Interface ContainerInterface
 * @package App\Container
 */
interface ContainerInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param string $id
     * @return bool
     */
    public function has($id);
}