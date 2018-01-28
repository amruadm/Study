<?php

define('ROOT_DIR', __DIR__);
define('SRC_DIR', 'src');
define('APP_NAME', 'App');

//Load Kernel
$kernel_directory = strtr(ROOT_DIR . '\\' . SRC_DIR . '\\Core\\Kernel.php', [
    '\\' => DIRECTORY_SEPARATOR
]);

require_once $kernel_directory;

//Init autoloader
spl_autoload_register('\App\Core\Kernel::autoloader');

require_once 'vendor/autoload.php';

//Configuration
$config_file = strtr(ROOT_DIR . '\\config\\config.json', [
    '\\' => DIRECTORY_SEPARATOR
]);

$json_data = file_get_contents($config_file);
$config = json_decode($json_data, true);

$container_data = [];

if (isset($config['container']))
    $container_data = $config['container'];

$kernel = new \App\Core\Kernel(new \App\Core\Container($container_data));
$kernel->run();