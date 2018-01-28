<?php

namespace App\Core;

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
            die('Failed to load class ' . $className . '(' . $fileName . ')');
        }
    }

    /**
     * Entry point
     */
    public function run()
    {
        //echo $_SERVER['REQUEST_URI'];
        $paramsPos = strrpos($_SERVER['REQUEST_URI'], '?');
        $routing = $_SERVER['REQUEST_URI'];
        if ($paramsPos > -1)
            $routing = substr($_SERVER['REQUEST_URI'], 0, $paramsPos);
        ltrim($routing, '/');

        echo $routing;
    }
}