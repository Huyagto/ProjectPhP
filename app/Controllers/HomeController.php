<?php
namespace Controllers;

use Core\Controller;
use Models\Movie;

class HomeController extends Controller {

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION["user"]["id"])) {
            return $this->userHome();
        }

        return $this->siteHome();
    }

    public function siteHome()
    {
        return $this->view("site/home", [
            'title' => 'MovieFlix – Xem phim miễn phí'
        ], "site");
    }

    public function userHome()
    {
        if (Movie::count() == 0) {
            Movie::autoFetchFullFromTMDB();
        }

        return $this->view("user/home", [
            'movies' => Movie::all(),
            'title'  => 'Trang chủ'
        ], "user");
    }
}
