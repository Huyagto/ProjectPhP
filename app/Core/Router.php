<?php
namespace Core;

use Middleware\AdminMiddleware;

class Router {

    public static function handle() {

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $publicPath = dirname($_SERVER['SCRIPT_NAME']);
        $uri = trim(str_replace($publicPath, '', $uri), '/');

        // ===========================
        // PUBLIC ROUTES
        // ===========================

        if ($uri === '' || $uri === 'home') {
            return (new \Controllers\HomeController())->index();
        }

        if ($uri === 'movies') {
            return (new \Controllers\User\HomeController())->index();
        }

        if (preg_match('#^movie/(\d+)$#', $uri, $m)) {
            return (new \Controllers\User\MovieController())->detail($m[1]);
        }

        if ($uri === 'search') {
            return (new \Controllers\User\MovieController())->search();
        }

        // ===========================
        // AUTH
        // ===========================

        if ($uri === 'login') {
            $auth = new \Controllers\AuthController();
            return $_SERVER['REQUEST_METHOD'] === 'POST'
                ? $auth->login()
                : $auth->showLogin();
        }

        if ($uri === 'register') {
            $auth = new \Controllers\AuthController();
            return $_SERVER['REQUEST_METHOD'] === 'POST'
                ? $auth->register()
                : $auth->showRegister();
        }

        if ($uri === 'logout') {
            return (new \Controllers\AuthController())->logout();
        }

        // ===========================
        // ADMIN ROUTES
        // ===========================

        if (strpos($uri, "admin") === 0) {
            AdminMiddleware::requireAdmin();
        }
        if ($uri === 'user/home') {
    return (new \Controllers\User\HomeController())->index();
}

        if ($uri === 'admin') {
            return (new \Controllers\Admin\DashboardController())->index();
        }

        $crudMap = [
            "users"      => \Controllers\Admin\UserController::class,
            "movies"     => \Controllers\Admin\MovieController::class,
            "authors"    => \Controllers\Admin\AuthorController::class,
            "categories" => \Controllers\Admin\CategoryController::class
        ];

        foreach ($crudMap as $name => $controller) {

            if ($uri === "admin/$name") return (new $controller())->index();
            if ($uri === "admin/$name/create") return (new $controller())->create();
            if ($uri === "admin/$name/store") return (new $controller())->store();

            if (preg_match("#^admin/$name/edit/(\d+)$#", $uri, $m)) {
                return (new $controller())->edit($m[1]);
            }

            if (preg_match("#^admin/$name/update/(\d+)$#", $uri, $m)) {
                return (new $controller())->update($m[1]);
            }

            if (preg_match("#^admin/$name/delete/(\d+)$#", $uri, $m)) {
                return (new $controller())->delete($m[1]);
            }
        }

        // ===========================
        // 404
        // ===========================
        http_response_code(404);
        echo "<h1 style='color:red;text-align:center;margin-top:50px;'>404 - Page Not Found</h1>";
        exit;
    }
}
