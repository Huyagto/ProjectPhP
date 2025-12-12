<?php
namespace Services;

use Models\Movie;
use Models\Author;
use Models\Category;
use Models\BaseModel;
use Services\TMDBService;   // <-- Cực kỳ quan trọng
use PDO;

class MovieService
{
    private TMDBService $tmdb;

    public function __construct()
    {
        $this->tmdb = new TMDBService();
    }

    public function countMoviesByYear()
    {
        $sql = "
            SELECT YEAR(release_date) AS year, COUNT(*) AS total
            FROM movies
            WHERE release_date IS NOT NULL
            GROUP BY YEAR(release_date)
            ORDER BY year ASC
        ";

        return BaseModel::getPDO()->query($sql)->fetchAll(PDO::FETCH_ASSOC);


    }

    public function fetchPopularMovies()
    {
        $data = $this->tmdb->getPopularMovies();
        if (empty($data["results"])) return;

        foreach ($data["results"] as $m) {

            $tmdb_id = $m["id"];

            if (Movie::existsWithTMDB($tmdb_id)) continue;

            $detail  = $this->tmdb->getMovieDetail($tmdb_id);
            if (!$detail) continue;

            $credits = $this->tmdb->getMovieCredits($tmdb_id);
            $videos  = $this->tmdb->getMovieVideos($tmdb_id);

            $director  = $this->tmdb->getDirector($credits);
            $author_id = Author::firstOrCreate($director);

            $genreNames = $this->tmdb->getGenres($detail);
            $genreIds   = Category::createManyIfNotExist($genreNames);

            $youtubeKey = $this->tmdb->extractTrailerKey($videos);

            $releaseDate = $detail["release_date"] 
                        ?? $m["release_date"] 
                        ?? null;

            if (!$releaseDate) continue;

            $year = substr($releaseDate, 0, 4);

            $poster   = $detail["poster_path"]   ?? null;
            $backdrop = $detail["backdrop_path"] ?? null;

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
        }
    }
}
