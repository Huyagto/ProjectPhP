<?php
namespace Controllers\Admin;

use Core\Controller;
use Middleware\AdminMiddleware;
use Models\User;
use Models\Movie;
use Models\Category;
use Models\Author;
use Services\MovieService;

class DashboardController extends Controller 
{
    public function index() 
    {
        // 🔒 Bắt buộc admin phải login
        $adminId = AdminMiddleware::requireAdmin();

        // Đếm số liệu
        $totalUsers   = User::count();
        $totalMovies  = Movie::count();
        $totalCats    = Category::count();
        $totalAuthors = Author::count();

        // Dữ liệu gần nhất
        $recentUsers  = User::recent(6);
        $recentMovies = Movie::recent(6);

        // Thống kê phim theo năm
        $movieService = new MovieService();
        $movieStats   = $movieService->countMoviesByYear();

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
