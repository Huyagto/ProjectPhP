<?php
namespace Services;

class TMDBService
{
    private $apiKey = "d802cfd406636ac7ae568c66b8ff5652";
    private $baseUrl = "https://api.themoviedb.org/3";

private function get($endpoint)
{
    $join = (str_contains($endpoint, '?')) ? "&" : "?";
    $url = $this->baseUrl . $endpoint . $join . "api_key=" . $this->apiKey;

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT        => 10
    ]);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        file_put_contents("debug_api.txt", "cURL ERROR: " . curl_error($curl) . "\n", FILE_APPEND);
        curl_close($curl);
        return null;
    }

    curl_close($curl);

    file_put_contents("debug_api.txt", "API OK: $url\n", FILE_APPEND);

    return json_decode($response, true);
}
public function extractTrailerKey($videos)
{
    if (empty($videos["results"])) return null;

    foreach ($videos["results"] as $v) {
        if ($v["site"] === "YouTube" && $v["type"] === "Trailer") {
            return $v["key"];
        }
    }

    return null;
}


    public function getPopularMovies($page = 1)
    {
        return $this->get("/movie/popular?language=vi-VN&page={$page}");
    }

    public function getMovieDetail($movieId)
    {
        return $this->get("/movie/{$movieId}?language=vi-VN");
    }

    public function getMovieCredits($movieId)
    {
        return $this->get("/movie/{$movieId}/credits"); // FIX
    }

    public function getMovieVideos($movieId)
    {
        return $this->get("/movie/{$movieId}/videos"); // FIX
    }

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

    public function getGenres($detail)
    {
        if (empty($detail["genres"])) return [];

        return array_map(fn($g) => $g["name"], $detail["genres"]);
    }

    public function getPosterUrl($path, $size = "w500")
    {
        if (!$path) return null;
        return "https://image.tmdb.org/t/p/{$size}{$path}";
    }
}
