<?php
namespace Controllers;

use Core\Controller;
use Models\Movie;

class HomeController extends Controller {

    public function index() {

        if (Movie::count() == 0) {
            Movie::autoFetchFullFromTMDB();
        }

        $movies = Movie::all();

        $username = $_SESSION['user']['username'] ?? null;

        return $this->view("site/home", [
            'movies' => $movies,
            'username' => $username
        ]);
    }
}
