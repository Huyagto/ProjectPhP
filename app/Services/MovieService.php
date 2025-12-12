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

    /* =============================
        LẤY SỐ LƯỢNG PHIM THEO NĂM
    ============================== */
    public function countMoviesByYear()
    {
        require __DIR__ . "/../../config/database.php";
        $db = $pdo;

        $sql = "SELECT YEAR(release_date) AS year, COUNT(*) AS total
                FROM movies
                WHERE release_date IS NOT NULL
                GROUP BY YEAR(release_date)
                ORDER BY year ASC";

        return $db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /* =============================
        FETCH POPULAR MOVIES
    ============================== */
    public function fetchPopularMovies()
    {
        require __DIR__ . "/../../config/database.php";
        $db = $pdo;

        file_put_contents("debug_service.txt", "=== Fetch bắt đầu ===\n");

        $data = $this->tmdb->getPopularMovies();
        file_put_contents("tmdb_response.json", json_encode($data, JSON_PRETTY_PRINT));

        if (empty($data["results"])) {
            file_put_contents("debug_service.txt", "❌ Không có results\n", FILE_APPEND);
            return;
        }

        foreach ($data["results"] as $m) {

            $tmdb_id = $m["id"];

            // Nếu phim đã tồn tại thì bỏ qua
            if (Movie::existsWithTMDB($tmdb_id)) {
                file_put_contents("debug_service.txt", "→ Skip (đã tồn tại)\n", FILE_APPEND);
                continue;
            }

            $detail  = $this->tmdb->getMovieDetail($tmdb_id);
            if (!$detail) continue;

            $credits = $this->tmdb->getMovieCredits($tmdb_id);
            $videos  = $this->tmdb->getMovieVideos($tmdb_id);

            /* === Director === */
            $director  = $this->tmdb->getDirector($credits);
            $author_id = Author::firstOrCreate($director);

            /* === Genres === */
            $genreNames = $this->tmdb->getGenres($detail);
            $genreIds   = Category::createManyIfNotExist($genreNames);

            /* === Trailer === */
            $youtubeKey = $this->tmdb->extractTrailerKey($videos);

            /* === Release date fallback === */
            $releaseDate = $detail["release_date"] ?? null;
            if (empty($releaseDate)) $releaseDate = $m["release_date"] ?? null;

            if (empty($releaseDate)) {
                $year = substr($detail["release_date"] ?? "", 0, 4);
                if (!$year) continue;
                $releaseDate = $year . "-01-01";
            }

            $year = substr($releaseDate, 0, 4);

            /* === Poster + Backdrop === */
            $poster   = $detail["poster_path"]   ?? null;
            $backdrop = $detail["backdrop_path"] ?? null;

            /* === INSERT MOVIE === */
            $movie_id = Movie::createFromTMDB([
                "tmdb_id"       => $tmdb_id,
                "title"         => $detail["title"],
                "overview"      => $detail["overview"] ?? "",
                "year"          => $year,
                "release_date"  => $releaseDate,
                "poster"        => $poster,
                "backdrop"      => $backdrop,
                "rating"        => $detail["vote_average"],
                "duration"      => $detail["runtime"],
                "trailer"       => $youtubeKey,
                "author_id"     => $author_id
            ]);

            Movie::syncCategories($movie_id, $genreIds);

            file_put_contents("debug_service.txt", "→ Insert OK (ID: $movie_id)\n", FILE_APPEND);
        }

        file_put_contents("debug_service.txt", "=== Fetch xong ===\n", FILE_APPEND);
    }
}
