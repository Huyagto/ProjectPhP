<?php
namespace Controllers\User;
use Core\Controller;
use Models\Movie;
class HomeController extends Controller {
    public function index()
{
    $movies = Movie::all();

    // Nếu DB ít hơn 5 phim → tránh lỗi
    $slider = count($movies) > 5 ? array_slice($movies, 0, 5) : $movies;

    return $this->view("user/home", [
        "movies" => $movies,
        "slider" => $slider
    ]);
}

}
