<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\User;

class UserController extends Controller {

    public function index() {
        return $this->adminView("admin/users/index", [
            "users" => User::all()
        ]);
    }

    public function create() {
        return $this->adminView("admin/users/create");
    }
    public function edit($id)
{
    $user = User::find($id);
    return $this->adminView("admin/users/edit", ['user' => $user]);
}

public function update($id)
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    User::update($id, [
        'username' => $username,
        'email' => $email,
        'role' => $role
    ]);

    return $this->redirect(BASE_URL . "/admin/users");
}
    public function store() {

        $username = $_POST["username"];
        $email    = $_POST["email"];
        $password = $_POST["password"];
        $role     = $_POST["role"];

        User::create($username, $email, $password, $role);

        return $this->redirect(BASE_URL . "/admin/users");
    }

    public function delete($id) {
        User::delete($id);
        return $this->redirect(BASE_URL . "/admin/users");
    }
}
