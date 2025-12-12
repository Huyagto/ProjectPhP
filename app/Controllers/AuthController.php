<?php
namespace Controllers;

use Core\Controller;
use Models\User;

class AuthController extends Controller {

    public function showLogin() {
        return $this->view("auth/login");
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $login = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = User::findByLogin($login);

            if ($user && password_verify($password, $user['password'])) {

                $_SESSION["user"] = $user;
                $_SESSION["user_id"] = $user["id"];   
                $_SESSION["name"] = $user["display_name"];
                $_SESSION["avatar"] = $user["avatar"];

                if ($user['role'] === 'admin' || $user['role'] == 1) {
                    header("Location: " . BASE_URL . "/admin");
                    exit;
                }

                header("Location: " . BASE_URL . "/user/home");
                exit;
            }

            return $this->view("auth/login", ['error' => "Sai thông tin đăng nhập!"]);
        }

        return $this->view("auth/login");
    }

    public function showRegister() {
        return $this->view("auth/register");
    }

    public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username     = trim($_POST["username"]);
        $email        = trim($_POST["email"]);
        $password     = trim($_POST["password"]);
        $display_name = trim($_POST["display_name"]);

        // KIỂM TRA TRÙNG
        if (User::exists($email, $username)) {
            return $this->view("auth/register", [
                'error' => "Tên đăng nhập hoặc email đã tồn tại!"
            ]);
        }

        // Tạo user mới
        User::create($username, $email, $password, $display_name);

        header("Location: " . BASE_URL . "/login");
        exit;
    }

    return $this->view("auth/register");
}


    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "/login");
        exit;
    }
}
