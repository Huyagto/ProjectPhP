<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\Movie;
use Models\Category;
use Models\Author;

class MovieController extends Controller
{
    /**
     * Trang danh sách phim
     */
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

    /**
     * Hiển thị form thêm
     */
    public function create()
    {
        return $this->adminView("admin/movies/create", [
            "authors"    => Author::all(),
            "categories" => Category::all()
        ]);
    }

    /**
     * Lưu phim mới
     */
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

        /* --- Upload poster --- */
        $poster = null;
        if (!empty($_FILES["poster"]["name"])) {
            $filename = time() . "_" . $_FILES["poster"]["name"];
            move_uploaded_file(
                $_FILES["poster"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $poster = $filename;
        }

        /* --- Upload backdrop --- */
        $backdrop = null;
        if (!empty($_FILES["backdrop"]["name"])) {
            $filename = time() . "_" . $_FILES["backdrop"]["name"];
            move_uploaded_file(
                $_FILES["backdrop"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $backdrop = $filename;
        }

        /* --- Lưu phim mới --- */
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

        /* --- Lưu thể loại --- */
        Movie::syncCategories($movie_id, $categories);

        return $this->redirect(BASE_URL . "/admin/movies");
    }

    /**
     * Hiển thị form chỉnh sửa
     */
    public function edit($id)
    {
        return $this->adminView("admin/movies/edit", [
            "movie"      => Movie::find($id),
            "authors"    => Author::all(),
            "categories" => Category::all(),
            "selected"   => Movie::getCategories($id)
        ]);
    }

    /**
     * Cập nhật phim
     */
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

        /* --- Upload poster mới nếu có --- */
        $poster = null;
        if (!empty($_FILES["poster"]["name"])) {
            $filename = time() . "_" . $_FILES["poster"]["name"];
            move_uploaded_file(
                $_FILES["poster"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $poster = $filename;
        }

        /* --- Upload backdrop mới nếu có --- */
        $backdrop = null;
        if (!empty($_FILES["backdrop"]["name"])) {
            $filename = time() . "_" . $_FILES["backdrop"]["name"];
            move_uploaded_file(
                $_FILES["backdrop"]["tmp_name"],
                __DIR__ . "/../../../public/uploads/" . $filename
            );
            $backdrop = $filename;
        }

        /* --- Cập nhật --- */
        Movie::updateFull($id, [
            "title"        => $title,
            "description"  => $desc,
            "year"         => $year,
            "release_date" => $release_date,
            "poster"       => $poster,     // null → giữ ảnh cũ
            "backdrop"     => $backdrop,   // null → giữ ảnh cũ
            "author_id"    => $author_id,
            "rating"       => $rating,
            "duration"     => $duration,
            "trailer"      => $trailer,
        ]);

        Movie::syncCategories($id, $categories);

        return $this->redirect(BASE_URL . "/admin/movies");
    }

    /**
     * Xóa phim
     */
    public function delete($id)
    {
        Movie::delete($id);
        return $this->redirect(BASE_URL . "/admin/movies");
    }
}
