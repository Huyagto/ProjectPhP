<?php
namespace Middleware;

class AuthMiddleware
{
    public static function requireLogin()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            $_SESSION['redirect_after_login'] = self::currentUrl();
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }
    private static function currentUrl()
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host   = $_SERVER['HTTP_HOST'] ?? '';
        $uri    = $_SERVER['REQUEST_URI'] ?? '/';

        return "$scheme://$host$uri";
    }
}
