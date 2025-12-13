<?php
namespace Services;

use Models\Movie;

class TMDBService
{
    private string $apiKey  = "d802cfd406636ac7ae568c66b8ff5652";
    private string $baseUrl = "https://api.themoviedb.org/3";
    private string $imgBase = "https://image.tmdb.org/t/p/";

    private function get(string $endpoint): ?array
    {
        $symbol = str_contains($endpoint, '?') ? '&' : '?';
        $url = "{$this->baseUrl}{$endpoint}{$symbol}api_key={$this->apiKey}";

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response ? json_decode($response, true) : null;
    }

    public function getPopularMovies(int $page = 1): ?array
    {
        return $this->get("/movie/popular?language=vi-VN&page={$page}");
    }

    public function getMovieDetail(int $movieId): ?array
    {
        return $this->get("/movie/{$movieId}?language=vi-VN");
    }

    public function getMovieCredits(int $movieId): ?array
    {
        return $this->get("/movie/{$movieId}/credits");
    }

    public function getMovieVideos(int $movieId): ?array
    {
        return $this->get("/movie/{$movieId}/videos");
    }

    public function getDirector(?array $credits): ?string
    {
        if (empty($credits["crew"])) return null;

        foreach ($credits["crew"] as $member) {
            if (($member["job"] ?? "") === "Director") {
                return $member["name"];
            }
        }
        return null;
    }

    public function extractTrailerKey(?array $videos): ?string
    {
        if (empty($videos["results"])) return null;

        foreach ($videos["results"] as $v) {
            if (($v["site"] ?? "") === "YouTube" && ($v["type"] ?? "") === "Trailer") {
                return $v["key"];
            }
        }
        return null;
    }

    public function getPosterUrl(?string $path, string $size = "w500"): ?string
    {
        return $path ? "{$this->imgBase}{$size}{$path}" : null;
    }

    /* ===== PHẢI NẰM TRONG CLASS ===== */
    public function fetchAndSaveMovies(int $pages = 1): int
    {
        $inserted = 0;

        for ($page = 1; $page <= $pages; $page++) {

            $popular = $this->getPopularMovies($page);
            if (empty($popular["results"])) continue;

            foreach ($popular["results"] as $m) {

                if (Movie::existsWithTMDB($m["id"])) continue;

                $detail  = $this->getMovieDetail($m["id"]);
                $videos  = $this->getMovieVideos($m["id"]);

                Movie::createFromTMDB([
                    "tmdb_id"      => $m["id"],
                    "title"        => $m["title"] ?? null,
                    "overview"     => $m["overview"] ?? null,
                    "year"         => substr($m["release_date"] ?? "", 0, 4),
                    "release_date" => $m["release_date"] ?? null,
                    "poster"       => $this->getPosterUrl($m["poster_path"]),
                    "backdrop"     => $this->getPosterUrl($m["backdrop_path"], "original"),
                    "rating"       => $m["vote_average"] ?? null,
                    "duration"     => $detail["runtime"] ?? null,
                    "trailer"      => $this->extractTrailerKey(
                                        $this->getMovieVideos($m["id"])
                                      ),
                    "author_id"    => null
                ]);

                $inserted++;
            }
        }

        return $inserted;
    }
}
