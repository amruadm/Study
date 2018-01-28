<?php

namespace App\Core;

use App\Core\Exception\CoreException;
use App\Psr\Container\ContainerInterface;

class Kernel
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * PSR-0 Autoloader
     *
     * @param $className
     * @throws CoreException
     */
    public static function autoloader($className)
    {
        $className = strtr($className, [
            '\\' => DIRECTORY_SEPARATOR,
            APP_NAME => SRC_DIR
        ]);

        $fileName = '';

        if ($lastSymbolPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastSymbolPos);
            $className = substr($className, $lastSymbolPos + 1);
            $fileName = $namespace . DIRECTORY_SEPARATOR;
        }

        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        $fileName = ROOT_DIR . DIRECTORY_SEPARATOR . $fileName;

        if (is_file($fileName)) {
            require_once $fileName;
        }
        else {
            throw new CoreException('Failed to load class ' . $className . '(' . $fileName . ')');
        }
    }

    /**
     * Entry point
     */
    public function run()
    {
        $router = new Router($this->container);
        $router->route();
    }
}