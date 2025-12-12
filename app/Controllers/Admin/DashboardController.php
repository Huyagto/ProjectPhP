<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\User;
use Models\Movie;
use Models\Category;
use Models\Author;
use Services\MovieService;

class DashboardController extends Controller {

    public function index() {

        // Tổng số
        $totalUsers   = method_exists(User::class,'count') ? User::count() : 0;
        $totalMovies  = method_exists(Movie::class,'count') ? Movie::count() : 0;
        $totalCats    = method_exists(Category::class,'count') ? Category::count() : 0;
        $totalAuthors = method_exists(Author::class,'count') ? Author::count() : 0;

        // Lấy dữ liệu mới nhất
        $recentUsers  = method_exists(User::class,'recent') ? User::recent(6) : [];
        $recentMovies = method_exists(Movie::class,'recent') ? Movie::recent(6) : [];

        // Lấy thống kê phim theo năm cho chart
        $movieService = new MovieService();
        $movieStats = $movieService->countMoviesByYear();

        // RETURN CHỈ 1 LẦN
        return $this->adminView("admin/dashboard", [
            "movieStats"   => $movieStats,
            "totalUsers"   => $totalUsers,
            "totalMovies"  => $totalMovies,
            "totalCats"    => $totalCats,
            "totalAuthors" => $totalAuthors,
            "recentUsers"  => $recentUsers,
            "recentMovies" => $recentMovies
        ]);
    }
}
