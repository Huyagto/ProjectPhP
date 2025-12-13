<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
define("BASE_URL", rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));
spl_autoload_register(function($class){
    $class = ltrim($class, '\\');
    $class = str_replace("\\", "/", $class);
    $file  = __DIR__ . "/../app/" . $class . ".php";
    if (file_exists($file)) require_once $file;
});
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../app/routes/web.php';
\Core\Router::handle();
