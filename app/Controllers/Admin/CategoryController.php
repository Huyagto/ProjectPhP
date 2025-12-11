<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\Category;

class CategoryController extends Controller {

    public function index() {
        return $this->adminView("admin/categories/index", [
            "categories" => Category::all()
        ]);
    }

    public function create() {
        return $this->adminView("admin/categories/create");
    }

    public function store() {
        Category::create($_POST["name"]);
        return $this->redirect(BASE_URL . "/admin/categories");
    }

    public function edit($id) {
        return $this->adminView("admin/categories/edit", [
            "category" => Category::find($id)
        ]);
    }

    public function update($id) {
        Category::update($id, $_POST["name"]);
        return $this->redirect(BASE_URL . "/admin/categories");
    }

    public function delete($id) {
        Category::delete($id);
        return $this->redirect(BASE_URL . "/admin/categories");
    }
}
