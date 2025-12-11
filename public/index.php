<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

/*
|--------------------------------------------------------------------------
| AUTO DETECT BASE_URL
|--------------------------------------------------------------------------
*/
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']); 
$basePath   = rtrim(dirname($scriptName), '/');

if (!defined('BASE_URL')) {
    define('BASE_URL', $basePath);
}

/*
|--------------------------------------------------------------------------
| AUTOLOAD
|--------------------------------------------------------------------------
*/
spl_autoload_register(function($class){
    $class = ltrim($class, '\\');          // bỏ dấu \ ở đầu
    $class = str_replace("\\", "/", $class); // đổi namespace → đường dẫn

    // ĐƯỜNG DẪN CHUẨN CHO DỰ ÁN CỦA BẠN
    $file = __DIR__ . "/../app/" . $class . ".php";

    if (file_exists($file)) {
        require_once $file;
    } else {
        // Debug để xem nó đang tìm file nào
        echo "Autoload không tìm thấy file: " . $file;
        exit;
    }
});



/*
|--------------------------------------------------------------------------
| DATABASE
|--------------------------------------------------------------------------
*/
require __DIR__ . '/../config/database.php';

/*
|--------------------------------------------------------------------------
| RUN ROUTER
|--------------------------------------------------------------------------
*/
\Core\Router::handle();
