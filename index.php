<?php

define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);

require_once ROOT_PATH . 'vendor/autoload.php';





// ...
$router = new Router(); 
$router->handleRequest($_GET);;