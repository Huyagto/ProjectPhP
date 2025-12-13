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
        $adminId = AdminMiddleware::requireAdmin();
        $totalUsers   = User::count();
        $totalMovies  = Movie::count();
        $totalCats    = Category::count();
        $totalAuthors = Author::count();
        $recentUsers  = User::recent(6);
        $recentMovies = Movie::recent(6);
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
