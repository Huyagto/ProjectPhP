<?php
namespace Core;

use Middleware\AdminMiddleware;

class Router
{
    public static function handle()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $rawUri = $_SERVER['REQUEST_URI'];

        // Chuẩn hoá URI
        $uri = parse_url($rawUri, PHP_URL_PATH);
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), "/");

        if ($scriptDir !== "") {
            $uri = str_replace($scriptDir, "", $uri);
        }

        $uri = trim($uri, "/");
        $uri = preg_replace('/\/+/', '/', $uri);

        foreach (Route::$routes as $route) {

            if ($route["method"] !== $method) continue;

            // Lấy tham số từ URL
            $params = [];
            if (!Route::matchUri($route["uri"], $uri, $params)) continue;

            // Middleware admin
            if ($route["middleware"] === "admin") {
                AdminMiddleware::requireAdmin();
            }

            // Xử lý controller + method
            [$controllerName, $methodName] = explode("@", $route["action"]);

            // Hỗ trợ namespace con
            // Ví dụ "Admin\\MovieController" → "Admin\MovieController"
            $controllerName = str_replace("/", "\\", $controllerName);
            $controllerName = str_replace("\\\\", "\\", $controllerName);

            // Ghép namespace gốc
            $controllerClass = "\\Controllers\\" . $controllerName;

            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller not found: " . $controllerClass);
            }

            $controllerInstance = new $controllerClass();

            if (!method_exists($controllerInstance, $methodName)) {
                throw new \Exception("Method '$methodName' not found in controller: " . $controllerClass);
            }

            // Gọi controller method
            return call_user_func_array([$controllerInstance, $methodName], $params);
        }

        // 404 fallback
        http_response_code(404);
        echo "<h1 style='color:red;text-align:center;margin-top:50px;'>404 - Page Not Found</h1>";
    }
}
