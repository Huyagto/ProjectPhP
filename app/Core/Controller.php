<?php
namespace Core;

class Controller {

    protected function view($path, $data = []) {
        extract($data);
        require __DIR__ . '/../Views/' . $path . '.php';
    }

  protected function adminView($path, $data = [])
{
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
