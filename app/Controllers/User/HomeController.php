<?php
namespace Controllers\User;

use Core\Controller;
use Models\Movie;

class HomeController extends Controller {

    public function index() {

        $movies = Movie::all();

        return $this->view("user/home", [
            "movies" => $movies
        ]);
    }
}
