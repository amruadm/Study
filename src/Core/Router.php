<?php

namespace App\Core;

use App\Core\Exception\CoreException;
use App\Psr\Container\ContainerInterface;

class Router
{
    protected $container;
    protected $config;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $config_path = ROOT_DIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'route.json';
        if (!is_file($config_path)) {
            throw new CoreException("route.json Not found");
        }

        $this->config = json_decode(file_get_contents($config_path), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new CoreException("route.json: " . json_last_error_msg());
        }
    }

    public function route()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $qIndex = strpos($uri, '?');
        if ($qIndex !== false)
            $uri = substr($uri, 0, $qIndex);

        if (!isset($this->config[$uri]))
            $uri = "NotFound";

        $controller_class = $this->config[$uri]['controller'];
        $calling_method = isset($this->config[$uri]['action']) ? $this->config[$uri]['action'] : "action";

        $controller_reflection = new \ReflectionClass($controller_class);
        $method_reflection = $controller_reflection->getMethod($calling_method);

        if (!isset($method_reflection))
            throw new CoreException('Undefined method \"' . $calling_method . '\" in controller ' . $controller_class);

        $args = [];

        $params = $method_reflection->getParameters();

        foreach ($params as $param) {
            $args[] = $this->container->get($param->getType()->getName());
        }

        $controller = $controller_reflection->newInstanceArgs([$this->container]);
        echo $method_reflection->invokeArgs($controller, $args);
    }
}