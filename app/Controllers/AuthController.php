<?php

namespace Controllers;

use Core\Controller;
use Models\User;

class AuthController extends Controller {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $login = trim($_POST['email']); 
            $password = trim($_POST['password']);

            $user = User::findByLogin($login);

            if ($user && password_verify($password, $user['password'])) {

                $_SESSION['user'] = $user;

                if ($user['role'] == 'admin' || $user['role'] == 1) {
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


    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (User::findByEmail($email)) {
                return $this->view("auth/register", ['error' => "Email đã tồn tại!"]);
            }

            User::create($username, $email, $password, 'user');

            header("Location: " . BASE_URL . "/login");
            exit;
        }

        return $this->view("auth/register");
    }

    public function showLogin() {
        return $this->view("auth/login");
    }

    public function showRegister() {
        return $this->view("auth/register");
    }

    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        header("Location: " . BASE_URL . "/login");
        exit;
    }
}
