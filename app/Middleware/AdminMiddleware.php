<?php
namespace Middleware;

class AdminMiddleware
{
    public static function requireAdmin()
    {
        // Nếu chưa đăng nhập → bắt login
        if (empty($_SESSION['user'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $role = $_SESSION['user']['role'] ?? 0;

        // 1 = admin, 0 = user → chỉ admin được vào
        if ($role != 1) {
            header("Location: " . BASE_URL . "/403");
            exit;
        }
    }
}
