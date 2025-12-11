<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\Movie;
use Models\Category;
use Models\Author;

class MovieController extends Controller {

    public function index() 
    {
        $keyword = $_GET["search"] ?? "";

        if ($keyword) {
            $movies = Movie::search($keyword);
        } else {
            $movies = Movie::all();
        }

        return $this->adminView("admin/movies/index", [
            "movies"  => $movies,
            "keyword" => $keyword
        ]);
    }

    public function create() 
    {
        return $this->adminView("admin/movies/create", [
            "authors"    => Author::all(),
            "categories" => Category::all()
        ]);
    }

    public function store() 
    {
        $title      = $_POST["title"];
        $desc       = $_POST["description"];
        $year       = $_POST["year"];
        $author_id  = $_POST["author_id"];
        $categories = $_POST["categories"] ?? [];

        $poster = null;

        if (!empty($_FILES["poster"]["name"])) {
            $filename = time() . "_" . $_FILES["poster"]["name"];
            move_uploaded_file(
                $_FILES["poster"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $poster = $filename;
        }

        $movie_id = Movie::create($title, $desc, $year, $poster, $author_id);

        Movie::syncCategories($movie_id, $categories);

        return $this->redirect(BASE_URL . "/admin/movies");
    }

    public function edit($id) 
    {
        return $this->adminView("admin/movies/edit", [
            "movie"      => Movie::find($id),
            "authors"    => Author::all(),
            "categories" => Category::all(),
            "selected"   => Movie::getCategories($id)
        ]);
    }

    public function update($id) 
    {
        $title      = $_POST["title"];
        $desc       = $_POST["description"];
        $year       = $_POST["year"];
        $author_id  = $_POST["author_id"];
        $categories = $_POST["categories"] ?? [];

        $poster = null;

        if (!empty($_FILES["poster"]["name"])) {
            $filename = time() . "_" . $_FILES["poster"]["name"];
            move_uploaded_file(
                $_FILES["poster"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $poster = $filename;
        }

        Movie::update($id, $title, $desc, $year, $poster, $author_id);

        Movie::syncCategories($id, $categories);

        return $this->redirect(BASE_URL . "/admin/movies");
    }

    public function delete($id)
    {
        Movie::delete($id);
        return $this->redirect(BASE_URL . "/admin/movies");
    }
}
