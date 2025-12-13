<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\Movie;
use Models\Category;
use Models\Author;
use Services\TMDBService;

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

    /* ================= FETCH TMDB ================= */
    public function fetch()
    {
        try {
            $tmdb = new TMDBService();
            $count = $tmdb->fetchAndSaveMovies(1); // fetch 1 page

            header("Content-Type: application/json");
            echo json_encode([
                "status"  => "success",
                "message" => "Đã thêm {$count} phim mới từ TMDB"
            ]);
            exit;

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status"  => "error",
                "message" => "Fetch thất bại!"
            ]);
            exit;
        }
    }

    public function store()
    {
        $movie_id = Movie::createFull($_POST);
        Movie::syncCategories($movie_id, $_POST["categories"] ?? []);
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
        Movie::updateFull($id, $_POST);
        Movie::syncCategories($id, $_POST["categories"] ?? []);
        return $this->redirect(BASE_URL . "/admin/movies");
    }

    public function delete($id)
    {
        Movie::delete($id);
        return $this->redirect(BASE_URL . "/admin/movies");
    }
}
