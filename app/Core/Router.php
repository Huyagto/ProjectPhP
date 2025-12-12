<?php
namespace Core;

use Middleware\AdminMiddleware;

class Router
{
    public static function handle()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Get real URI
        $rawUri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($rawUri, PHP_URL_PATH);

        // Remove /ProjectPhP/public dynamically
       $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), "/");
if ($scriptDir !== "") {
    $uri = str_replace($scriptDir, "", $uri);
}

        // Normalize
        $uri = trim($uri, "/");
        $uri = preg_replace('/\/+/', '/', $uri);

        // Debug
        file_put_contents("route_debug.txt",
            "\n--- CHECK FOR URI: $uri ---\n",
            FILE_APPEND
        );

        // Loop routes
        foreach (Route::$routes as $route) {

            file_put_contents("route_debug.txt",
                "TRY: ".$route["method"]." ".$route["uri"]."\n",
                FILE_APPEND
            );

            if ($route["method"] !== $method) continue;

            $params = [];

            if (Route::matchUri($route["uri"], $uri, $params)) {

                file_put_contents("route_debug.txt",
                    "--> MATCH SUCCESS: ".$route["uri"]." PARAMS=".json_encode($params)."\n",
                    FILE_APPEND
                );

                // Middleware
                if ($route["middleware"] === "admin") {
                    AdminMiddleware::requireAdmin();
                }

                [$controller, $methodName] = explode("@", $route["action"]);
                $controller = "\\Controllers\\" . $controller;

                return call_user_func_array([new $controller, $methodName], $params);
            }
        }

        // No match found
        file_put_contents("route_debug.txt",
            "!!! NO ROUTE MATCH FOR: $uri\n",
            FILE_APPEND
        );

        http_response_code(404);
        echo "<h1 style='color:red;text-align:center;margin-top:50px;'>404 - Page Not Found</h1>";
    }
}
