<?php
namespace Services;

class TMDBService
{
    private $apiKey = "af69a70274d4ddc4b8bd3ce03b195744";
    private $baseUrl = "https://api.themoviedb.org/3";

    // Gọi API chung
    private function get($endpoint)
    {
        $url = $this->baseUrl . $endpoint . "&api_key=" . $this->apiKey;

        $json = @file_get_contents($url);
        return $json ? json_decode($json, true) : null;
    }

    // Lấy danh sách phim phổ biến
    public function getPopularMovies($page = 1)
    {
        return $this->get("/movie/popular?language=vi-VN&page={$page}");
    }

    // Lấy chi tiết phim
    public function getMovieDetail($movieId)
    {
        return $this->get("/movie/{$movieId}?language=vi-VN");
    }

    // Lấy credits (để lấy đạo diễn)
    public function getMovieCredits($movieId)
    {
        return $this->get("/movie/{$movieId}/credits?");
    }

    // Lấy danh sách video (Trailer, Clip, Teaser) — *** HÀM BẠN THIẾU ***
    public function getMovieVideos($movieId)
    {
        return $this->get("/movie/{$movieId}/videos?");
    }

    // Lấy tên đạo diễn
    public function getDirector($credits)
    {
        if (empty($credits["crew"])) return null;

        foreach ($credits["crew"] as $c) {
            if ($c["job"] === "Director") {
                return $c["name"];
            }
        }
        return null;
    }

    // Parse genres → array tên
    public function getGenres($detail)
    {
        if (empty($detail["genres"])) return [];

        return array_map(fn($g) => $g["name"], $detail["genres"]);
    }

    // Lấy link poster TMDB
    public function getPosterUrl($path, $size = "w500")
    {
        if (!$path) return null;
        return "https://image.tmdb.org/t/p/{$size}{$path}";
    }
}
