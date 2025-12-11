<?php
namespace Middleware;

class AdminMiddleware
{
    public static function requireAdmin()
    {
        if (empty($_SESSION['user'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['role'] != 1) {
            http_response_code(403);
            echo "<h1 style='color:red;text-align:center;margin-top:50px;'>403 - Bạn không có quyền truy cập trang này.</h1>";
            exit;
        }
    }
}
