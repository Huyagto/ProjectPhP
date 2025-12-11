<?php

namespace Controllers\User;

use Core\Controller;
use Services\MovieService;

class MovieController extends Controller
{
    private $movie;

    public function __construct()
    {
        $this->movie = new MovieService();
    }

    public function index()
    {
        $movies = $this->movie->popular();
        return $this->view("user/movies", ["movies" => $movies['results']]);
    }

    public function detail($id)
    {
        $movie = $this->movie->detail($id);
        return $this->view("user/movie_detail", ["movie" => $movie]);
    }

    public function search()
    {
        $keyword = $_GET['q'] ?? '';
        $result = $this->movie->search($keyword);

        return $this->view("user/search", [
            "movies" => $result['results'],
            "keyword" => $keyword
        ]);
    }
}
