<?php
namespace Middleware;

class AuthMiddleware
{
    public static function requireLogin()
    {
        if (empty($_SESSION['user'])) {
            // Lưu URL để redirect lại sau đăng nhập
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }
}
