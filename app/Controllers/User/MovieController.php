<?php

namespace Controllers\User;

use Core\Controller;
use Models\Movie;
use Services\MovieService;
use Services\TMDBService;

class MovieController extends Controller
{
    private $movieService;

    public function __construct()
    {
        $this->movieService = new MovieService();
    }   

    public function index()
    {
        $movies = $this->movieService->popular();
        return $this->view("user/movies", ["movies" => $movies['results']]);
    }

    public function detail($id)
    {
        // Lấy phim từ database
        $movie = Movie::find($id);

        if (!$movie) {
            die("Phim không tồn tại");
        }

        // Lấy phim tương tự
        $related_movies = Movie::getRelated($movie["categories"], $id);

        // ======= LẤY TRAILER TỪ TMDB =======
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

        return $this->view("user/movie_detail", [
            "movie" => $movie,
            "related_movies" => $related_movies,
            "youtubeKey" => $youtubeKey
        ]);
    }

    public function search()
    {
        $keyword = $_GET['q'] ?? '';
        $result = $this->movieService->search($keyword);

        return $this->view("user/search", [
            "movies" => $result['results'],
            "keyword" => $keyword
        ]);
    }
}
