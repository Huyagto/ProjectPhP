<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\User;

class UserController extends Controller {
    public function index()
    {
        $keyword = $_GET["search"] ?? "";

        $users = $keyword
            ? User::search($keyword)
            : User::all();

        return $this->adminView("admin/users/index", [
            "users"   => $users,
            "keyword" => $keyword
        ]);
    }
    public function create() {
        return $this->adminView("admin/users/create");
    }
    public function store()
    {
        $username      = $_POST["username"];
        $email         = $_POST["email"];
        $password      = $_POST["password"];
        $display_name  = $_POST["display_name"];
        $role          = $_POST["role"];
        User::create($username, $email, $password, $display_name, $role);
        return $this->redirect(BASE_URL . "/admin/users");
    }
    public function edit($id)
    {
        $user = User::find($id);
        return $this->adminView("admin/users/edit", ['user' => $user]);
    }
    public function update($id)
    {
        $username      = $_POST['username'];
        $email         = $_POST['email'];
        $display_name  = $_POST['display_name'];
        $role          = $_POST['role'];
       $avatar = null;

if (!empty($_FILES["avatar"]["name"]) && $_FILES["avatar"]["error"] === UPLOAD_ERR_OK) {

    $fileName = time() . "_" . basename($_FILES["avatar"]["name"]);
    $uploadDir = __DIR__ . "/../../../public/img/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $uploadDir . $fileName)) {
        $avatar = "img/" . $fileName;
    }
}
        $password = !empty($_POST['password']) ? $_POST["password"] : null;
        User::update($id, $username, $email, $display_name, $password, $role, $avatar);
        return $this->redirect(BASE_URL . "/admin/users");
    }
    public function delete($id)
    {
        User::delete($id);
        return $this->redirect(BASE_URL . "/admin/users");
    }
}
