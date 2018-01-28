<?php

namespace App\Core;


use App\Core\Exception\ContainerException;
use App\Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private $container = [];

    public function __construct($container_data)
    {
        $this->container = $container_data;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws ContainerException
     */
    public function get($id)
    {
        if ($this->has($id)) {
            $classInfo = new \ReflectionClass(class_exists($id) ? $id : $this->container[$id]['class']);
            $constructor = $classInfo->getConstructor();
            $args = [];
            if (isset($constructor)) {
                $params = $constructor->getParameters();
                foreach ($params as $param) {
                    $args[] = $this->get($param->getType());
                }
            }
            return $classInfo->newInstanceArgs($args);
        }
        throw new ContainerException();
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return isset($this->container[$id]);
    }
}