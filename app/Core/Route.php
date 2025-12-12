<?php
namespace Core;
class Route{
    public static array $routes = [];
    public static function add($method, $uri, $action, $middleware = null){
        self::$routes[] = [
            "method"     => strtoupper($method),
            "uri"        => trim($uri, "/"),
            "action"     => $action,
            "middleware" => $middleware
        ];
    }
    public static function get($uri, $action, $middleware = null){
        self::add("GET", $uri, $action, $middleware);
    }

    public static function post($uri, $action, $middleware = null){
        self::add("POST", $uri, $action, $middleware);
    }

public static function matchUri($routeUri, $currentUri, &$params){
    $routeUri   = trim($routeUri, "/");
    $currentUri = trim($currentUri, "/");
    $routeParts   = explode("/", $routeUri);
    $currentParts = explode("/", $currentUri);
    if (count($routeParts) !== count($currentParts)) {
        return false;
    }
    $params = [];
    foreach ($routeParts as $i => $part) {
        if (preg_match('/^{(.+)}$/', $part, $m)) {
            $params[$m[1]] = $currentParts[$i];
            continue;
        }
        if ($part !== $currentParts[$i]) {
            return false;
        }
    }

    return true;
}



}
