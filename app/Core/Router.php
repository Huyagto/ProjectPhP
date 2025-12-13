<?php
namespace Core;

use Middleware\AdminMiddleware;

class Router
{
    public static function handle()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $rawUri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($rawUri, PHP_URL_PATH);
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), "/");
        if ($scriptDir !== "") {
            $uri = str_replace($scriptDir, "", $uri);
        }
        $uri = trim($uri, "/");
        $uri = preg_replace('/\/+/', '/', $uri);
        foreach (Route::$routes as $route) {
            if ($route["method"] !== $method) continue;
            $params = [];
            if (!Route::matchUri($route["uri"], $uri, $params)) continue;
            if ($route["middleware"] === "admin") {
                AdminMiddleware::requireAdmin();
            }
            [$controllerName, $methodName] = explode("@", $route["action"]);
            $controllerName = str_replace("/", "\\", $controllerName);
            $controllerName = str_replace("\\\\", "\\", $controllerName);
            $controllerClass = "\\Controllers\\" . $controllerName;
            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller not found: " . $controllerClass);
            }
            $controllerInstance = new $controllerClass();

            if (!method_exists($controllerInstance, $methodName)) {
                throw new \Exception("Method '$methodName' not found in controller: " . $controllerClass);
            }
            return call_user_func_array([$controllerInstance, $methodName], $params);
        }
        http_response_code(404);
        echo "<h1 style='color:red;text-align:center;margin-top:50px;'>404 - Page Not Found</h1>";
    }
}
