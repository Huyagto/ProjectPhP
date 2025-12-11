<?php

namespace Controllers\User;

use Core\Controller;
use Models\Movie;
use Services\MovieService;

class MovieController extends Controller
{
    private $movieService;

    public function __construct()
    {
        $this->movieService = new MovieService();
    }

    public function index()
    {
        $movies = $this->movieService->popular();
        return $this->view("user/movies", ["movies" => $movies['results']]);
    }

   public function detail($id)
{
    // Lấy phim theo ID từ database
    $movie = Movie::find($id);

    if (!$movie) {
        die("Phim không tồn tại");
    }

    // Lấy phim tương tự dựa trên categories
    $related_movies = Movie::getRelated($movie['categories'], $id);

    return $this->view("user/movie_detail", [
        "movie" => $movie,
        "related_movies" => $related_movies
    ]);
}

    public function search()
    {
        $keyword = $_GET['q'] ?? '';
        $result = $this->movieService->search($keyword);

        return $this->view("user/search", [
            "movies" => $result['results'],
            "keyword" => $keyword
        ]);
    }
}
