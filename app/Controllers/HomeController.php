<?php
namespace Controllers;

use Core\Controller;
use Models\Movie;

class HomeController extends Controller {

    public function index() {

        // Tự tải phim nếu DB trống
        if (Movie::count() == 0) {
            Movie::autoFetchFullFromTMDB();
        }

        $movies = Movie::all();

        // Lấy user nếu đăng nhập
        $currentUser = $_SESSION["user"] ?? null;

        // ---- Nếu user đã đăng nhập → Vào giao diện người dùng ----
        if (!empty($currentUser["id"])) {
            return $this->view("user/home", [
                'movies'   => $movies,
                'username' => $currentUser["username"] ?? null,
                'title'    => 'Trang chủ'
            ], "user");
        }

        // ---- Nếu chưa đăng nhập → Giao diện landing page ----
        return $this->view("site/home", [
            'title' => 'MovieFlix – Xem phim miễn phí'
        ], "site");
    }
}
