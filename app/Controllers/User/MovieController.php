<?php
namespace Controllers\User;

use Core\Controller;
use Models\Movie;
use Models\Watchlist;
use Services\TMDBService;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return $this->view("user/movies", ["movies" => $movies]);
    }

    public function detail($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $movie = Movie::find($id);
        if (!$movie) {
            die("Phim không tồn tại");
        }
        $related = Movie::getRelated($movie["categories"], $id);
        $tmdb = new TMDBService();
        $videos = $tmdb->getMovieVideos($movie["tmdb_id"]);

        $youtubeKey = null;

        if (!empty($videos["results"])) {
            foreach ($videos["results"] as $v) {
                if (
                    $v["site"] === "YouTube"
                    && ($v["type"] === "Trailer" || $v["type"] === "Teaser")
                ) {
                    $youtubeKey = $v["key"];
                    break;
                }
            }
        }

        // Kiểm tra đã lưu Watchlist chưa
        $isAdded = false;
        if (!empty($_SESSION["user"]["id"])) {
            $userId = $_SESSION["user"]["id"];
            $isAdded = Watchlist::exists($userId, $id);
        }

        return $this->view("user/movie_detail", [
            "movie"          => $movie,
            "related_movies" => $related,
            "youtubeKey"     => $youtubeKey,
            "isAdded"        => $isAdded
        ]);
    }

    // SEARCH
    public function search()
    {
        $keyword = $_GET['q'] ?? '';
        $movies  = Movie::search($keyword);

        return $this->view("user/search", [
            "movies"  => $movies,
            "keyword" => $keyword
        ]);
    }
}
