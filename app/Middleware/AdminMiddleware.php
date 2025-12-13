<?php
namespace Middleware;

class AdminMiddleware
{
    public static function requireAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION["user"])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
        if ($_SESSION["user"]["role"] !== "admin" && $_SESSION["user"]["role"] != 1) {
            http_response_code(403);
            echo "<h1 style='color:red; text-align:center; margin-top:40px'>🚫 Không có quyền truy cập</h1>";
            exit;
        }
        return $_SESSION["user"]["id"];
    }
}
