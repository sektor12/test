<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'test');

$config['mainBackendTheme'] = 'adminSimpleGreen';
$config['mainFrontendTheme'] = 'myTheme';

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

/**
 * Autoloading classes
 */
spl_autoload_register(function($className) {
    $cls = str_replace('\\', '/', $className);
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/core/' . $cls . '.php')) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/' . $cls . '.php');
        return;
    }
});
