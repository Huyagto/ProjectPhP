<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\Movie;
use Models\Category;
use Models\Author;

class MovieController extends Controller
{
   public function index()
{
    $search   = $_GET["search"]   ?? "";
    $category = $_GET["category"] ?? "";
    $author   = $_GET["author"]   ?? "";
    $year     = $_GET["year"]     ?? "";

    $movies = Movie::filter($search, $category, $author, $year);

    return $this->adminView("admin/movies/index", [
        "movies"     => $movies,
        "categories" => Category::all(),
        "authors"    => Author::all(),
        "keyword"    => $search
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
        $title        = $_POST["title"];
        $desc         = $_POST["description"];
        $year         = $_POST["year"];
        $release_date = $_POST["release_date"];
        $rating       = $_POST["rating"];
        $duration     = $_POST["duration"];
        $trailer      = $_POST["trailer"];
        $author_id    = $_POST["author_id"];
        $categories   = $_POST["categories"] ?? [];
        $poster = null;
        if (!empty($_FILES["poster"]["name"])) {
            $filename = time() . "_" . $_FILES["poster"]["name"];
            move_uploaded_file(
                $_FILES["poster"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $poster = $filename;
        }
        $backdrop = null;
        if (!empty($_FILES["backdrop"]["name"])) {
            $filename = time() . "_" . $_FILES["backdrop"]["name"];
            move_uploaded_file(
                $_FILES["backdrop"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $backdrop = $filename;
        }
        $movie_id = Movie::createFull([
            "title"        => $title,
            "description"  => $desc,
            "year"         => $year,
            "release_date" => $release_date,
            "poster"       => $poster,
            "backdrop"     => $backdrop,
            "author_id"    => $author_id,
            "rating"       => $rating,
            "duration"     => $duration,
            "trailer"      => $trailer,
        ]);
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
        $title        = $_POST["title"];
        $desc         = $_POST["description"];
        $year         = $_POST["year"];
        $release_date = $_POST["release_date"];
        $rating       = $_POST["rating"];
        $duration     = $_POST["duration"];
        $trailer      = $_POST["trailer"];
        $author_id    = $_POST["author_id"];
        $categories   = $_POST["categories"] ?? [];
        $poster = null;
        if (!empty($_FILES["poster"]["name"])) {
            $filename = time() . "_" . $_FILES["poster"]["name"];
            move_uploaded_file(
                $_FILES["poster"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $poster = $filename;
        }
        $backdrop = null;
        if (!empty($_FILES["backdrop"]["name"])) {
            $filename = time() . "_" . $_FILES["backdrop"]["name"];
            move_uploaded_file(
                $_FILES["backdrop"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $backdrop = $filename;
        }
        Movie::updateFull($id, [
            "title"        => $title,
            "description"  => $desc,
            "year"         => $year,
            "release_date" => $release_date,
            "poster"       => $poster,     
            "backdrop"     => $backdrop,  
            "author_id"    => $author_id,
            "rating"       => $rating,
            "duration"     => $duration,
            "trailer"      => $trailer,
        ]);
        Movie::syncCategories($id, $categories);
        return $this->redirect(BASE_URL . "/admin/movies");
    }
    public function delete($id)
    {
        Movie::delete($id);
        return $this->redirect(BASE_URL . "/admin/movies");
    }
}
