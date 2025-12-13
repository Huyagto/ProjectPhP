<?php
namespace Controllers;

use Core\Controller;
use Models\User;

class AuthController extends Controller {

    public function showLogin() {
        return $this->view("auth/login", [], "auth");
    }

    public function login() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $login    = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = User::findByLogin($login);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION["user"] = [
                    "id"           => $user["id"],
                    "username"     => $user["username"],   
                    "display_name" => $user["display_name"],
                    "email"        => $user["email"],
                    "role"         => $user["role"],
                    "avatar"       => $user["avatar"] ?? "default-avatar.png"
                ];
                if ($user['role'] == 1) {
                    header("Location: " . BASE_URL . "/admin");
                    exit;
                }
                header("Location: " . BASE_URL . "/user/home");
                exit;
            }

            return $this->view("auth/login", [
                'error' => "Sai thông tin đăng nhập!"
            ], "auth");
        }

        return $this->view("auth/login", [], "auth");
    }


    public function showRegister() {
        return $this->view("auth/register", [], "auth");
    }

    public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username     = trim($_POST["username"]);
        $email        = trim($_POST["email"]);
        $password     = trim($_POST["password"]);
        $display_name = trim($_POST["display_name"]);
        if (strlen($password) < 6) {
            return $this->view("auth/register", [
                'error' => "Mật khẩu phải có ít nhất 6 ký tự!"
            ], "auth");
        }
        if (User::exists($email, $username)) {
            return $this->view("auth/register", [
                'error' => "Tên đăng nhập hoặc email đã tồn tại!"
            ], "auth");
        }
        User::create($username, $email, $password, $display_name);

        header("Location: " . BASE_URL . "/login");
        exit;
    }

    return $this->view("auth/register", [], "auth");
}



    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: " . BASE_URL . "/site/home");
        exit;
    }
}
