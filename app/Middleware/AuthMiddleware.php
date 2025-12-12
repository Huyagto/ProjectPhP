<?php
namespace Middleware;

class AuthMiddleware
{
    public static function requireLogin()
    {
        // Chưa đăng nhập
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {

            // Lưu URL hiện tại để redirect sau đăng nhập
            $_SESSION['redirect_after_login'] = self::currentUrl();

            // Chuyển hướng đến trang login
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    // Lấy URL hiện tại một cách an toàn
    private static function currentUrl()
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host   = $_SERVER['HTTP_HOST'] ?? '';
        $uri    = $_SERVER['REQUEST_URI'] ?? '/';

        return "$scheme://$host$uri";
    }
}
