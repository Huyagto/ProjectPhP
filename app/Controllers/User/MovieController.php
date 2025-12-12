<?php

namespace Controllers\User;
use Models\Watchlist;
use Core\Controller;
use Models\Movie;
use Services\TMDBService;

class MovieController extends Controller
{
    // LIST MOVIES TRANG USER
    public function index()
    {
        $movies = Movie::all();
        return $this->view("user/movies", ["movies" => $movies]);
    }

    // MOVIE DETAIL
   public function detail($id)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $movie = Movie::find($id);
    if (!$movie) {
        die("Phim không tồn tại");
    }

    // Phim tương tự 
    $related = Movie::getRelated($movie["categories"], $id);

    // Lấy trailer từ TMDB
    $tmdb = new TMDBService();
    $videos = $tmdb->getMovieVideos($movie["tmdb_id"]);

    $youtubeKey = null;
    if (!empty($videos["results"])) {
        foreach ($videos["results"] as $v) {
            if ($v["site"] === "YouTube" &&
                ($v["type"] === "Trailer" || $v["type"] === "Teaser")) 
            {
                $youtubeKey = $v["key"];
                break;
            }
        }
    }

    // 🔥 KIỂM TRA XEM PHIM ĐÃ ĐƯỢC THÊM VÀO WATCHLIST CHƯA
    $isAdded = false;

    if (!empty($_SESSION["user"]["id"])) {
        $isAdded = Watchlist::exists($_SESSION["user"]["id"], $id);
    }

    return $this->view("user/movie_detail", [
        "movie" => $movie,
        "related_movies" => $related,
        "youtubeKey" => $youtubeKey,
        "isAdded" => $isAdded  // 🔥 GỬI SANG VIEW, KHÔNG LÀ BÁO LỖI!
    ]);
}


    // SEARCH
    public function search()
    {
        $keyword = $_GET['q'] ?? '';
        $movies = Movie::search($keyword);

        return $this->view("user/search", [
            "movies" => $movies,
            "keyword" => $keyword
        ]);
    }
}
