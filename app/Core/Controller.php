<?php
namespace Core;

use Models\User;

class Controller {

    // Tự động lấy user đang đăng nhập
    protected function shareUser()
    {
        if (!empty($_SESSION["user_id"])) {
            return User::find($_SESSION["user_id"]);
        }
        return null;
    }

    // VIEW CHO USER
    protected function view($path, $data = [])
    {
        // Thêm currentUser vào view
        $data["currentUser"] = $this->shareUser();

        extract($data);
        require __DIR__ . '/../Views/' . $path . '.php';
    }

    // VIEW CHO ADMIN
    protected function adminView($path, $data = [])
    {
        $data["currentUser"] = $this->shareUser();

        extract($data);

        ob_start();
        require __DIR__ . '/../Views/' . $path . '.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/admin.php';
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}
