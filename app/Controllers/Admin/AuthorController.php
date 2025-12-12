<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\Author;

class AuthorController extends Controller {

public function index()
{
    $keyword = $_GET["search"] ?? "";

    $authors = $keyword 
        ? Author::search($keyword)
        : Author::all();

    return $this->adminView("admin/authors/index", [
        "authors" => $authors,
        "keyword" => $keyword
    ]);
}



    public function create() {
        return $this->adminView("admin/authors/create");
    }

    public function store() {
        Author::create($_POST['name']);
        return $this->redirect(BASE_URL . "/admin/authors");
    }

    public function edit($id) {
        $author = Author::find($id);
        return $this->adminView("admin/authors/edit", compact('author'));
    }

    public function update($id) {
        Author::update($id, $_POST['name']);
        return $this->redirect(BASE_URL . "/admin/authors");
    }

    public function delete($id) {
        Author::delete($id);
        return $this->redirect(BASE_URL . "/admin/authors");
    }
}
