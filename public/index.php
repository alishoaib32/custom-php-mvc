<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Autoloader
require_once '../vendor/autoload.php';

// Load Config
require_once '../config/config.php';


// Setup Logging env
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$stream = new StreamHandler('logs/boozt.log', Logger::DEBUG);
$logger = new Logger('debug');
$logger->pushHandler($stream);

System\Router::start();

