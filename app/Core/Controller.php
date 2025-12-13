<?php
namespace Core;

use Models\User;

class Controller {

    protected function shareUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return !empty($_SESSION["user"]["id"])
            ? User::find($_SESSION["user"]["id"])
            : null;
    }

    protected function view($path, $data = [], $layout = "user")
    {
        $data["currentUser"] = $this->shareUser();

        extract($data);

        ob_start();
        require __DIR__ . "/../Views/" . $path . ".php";
        $content = ob_get_clean();

        require __DIR__ . "/../Views/layout/" . $layout . ".php";
    }

    protected function adminView($path, $data = [])
    {
        $data["currentUser"] = $this->shareUser();

        extract($data);

        ob_start();
        require __DIR__ . '/../Views/' . $path . '.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/admin.php';
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
