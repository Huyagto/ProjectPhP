<?php
namespace Services;

use Models\Movie;
use Models\Author;
use Models\Category;

class MovieService
{
    private $tmdb;

    public function __construct()
    {
        $this->tmdb = new TMDBService();
    }

    public function fetchPopularMovies()
    {
        $data = $this->tmdb->getPopularMovies();

        if (empty($data["results"])) return;

        foreach ($data["results"] as $m) {

            $tmdb_id = $m["id"];

            // Nếu phim đã có thì bỏ qua
            if (Movie::existsWithTMDB($tmdb_id)) continue;

            // Lấy thông tin phim chi tiết
            $detail  = $this->tmdb->getMovieDetail($tmdb_id);
            $credits = $this->tmdb->getMovieCredits($tmdb_id);

            if (!$detail) continue;

            // --- AUTHOR ---
            $director = $this->tmdb->getDirector($credits);
            $author_id = Author::firstOrCreate($director);

            // --- GENRES ---
            $genreNames = $this->tmdb->getGenres($detail);
            $genreIds   = Category::createManyIfNotExist($genreNames);

            // --- MOVIE ---
            $movie_id = Movie::createFromTMDB($detail, $tmdb_id, $author_id);

            // --- MAP CATEGORIES ---
            Movie::syncCategories($movie_id, $genreIds);
        }
    }
}
