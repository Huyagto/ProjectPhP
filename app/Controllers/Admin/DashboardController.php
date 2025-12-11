<?php
namespace Controllers\Admin;

use Core\Controller;
use Models\User;
use Models\Movie;
use Models\Category;
use Models\Author;

class DashboardController extends Controller {
    public function index() {
        // count helpers (models phải có count())
        $totalUsers = method_exists(User::class,'count') ? User::count() : 0;
        $totalMovies = method_exists(Movie::class,'count') ? Movie::count() : 0;
        $totalCats = method_exists(Category::class,'count') ? Category::count() : 0;
        $totalAuthors = method_exists(Author::class,'count') ? Author::count() : 0;

        // recent lists
        $recentUsers = method_exists(User::class,'recent') ? User::recent(6) : [];
        $recentMovies = method_exists(Movie::class,'recent') ? Movie::recent(6) : [];

        return $this->adminView('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'totalMovies' => $totalMovies,
            'totalCats' => $totalCats,
            'totalAuthors' => $totalAuthors,
            'recentUsers' => $recentUsers,
            'recentMovies' => $recentMovies,
        ]);
    }
}
