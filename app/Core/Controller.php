<?php
namespace Core;

use Models\User;

class Controller {

    protected function shareUser()
    {
        return !empty($_SESSION["user_id"])
            ? User::find($_SESSION["user_id"])
            : null;
    }

    protected function view($path, $data = [], $layout = "user")
    {
        // inject currentuser
        $data["currentUser"] = $this->shareUser();

        // biến được truyền vào view, KHÔNG phá các biến quan trọng khác
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        // Render view con
        ob_start();
        require __DIR__ . "/../Views/" . $path . ".php";
        $content = ob_get_clean();

        // Render layout (layout nhận biến: content + currentUser + title...)
        require __DIR__ . "/../Views/layout/" . $layout . ".php";
    }

    protected function adminView($path, $data = [])
    {
        $data["currentUser"] = $this->shareUser();

        foreach ($data as $key => $value) {
            $$key = $value;
        }

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
