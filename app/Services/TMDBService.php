<?php
namespace Services;

class TMDBService
{
    private string $apiKey   = "d802cfd406636ac7ae568c66b8ff5652";
    private string $baseUrl  = "https://api.themoviedb.org/3";
    private string $imgBase  = "https://image.tmdb.org/t/p/";

    /* =======================================================
        CORE API GET HELPER (CLEAN VERSION)
    ======================================================== */
    private function get(string $endpoint): ?array
    {
        // Xử lý auto thêm ? hoặc &
        $symbol = str_contains($endpoint, '?') ? '&' : '?';
        $url    = "{$this->baseUrl}{$endpoint}{$symbol}api_key={$this->apiKey}";

        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $response = curl_exec($curl);

        // Lỗi cURL
        if ($response === false) {
            $error = curl_error($curl);
            file_put_contents("debug_api.txt", "❌ cURL ERROR: $error\n", FILE_APPEND);
            curl_close($curl);
            return null;
        }

        curl_close($curl);

        file_put_contents("debug_api.txt", "✔ API OK: $url\n", FILE_APPEND);

        return json_decode($response, true);
    }

    /* =======================================================
        TMDB ENDPOINTS
    ======================================================== */
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

    /* =======================================================
        DATA HELPERS (CLEAN)
    ======================================================== */

    /** Lấy Director từ credits */
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

    /** Lấy danh sách Genre (name only) */
    public function getGenres(?array $detail): array
    {
        if (empty($detail["genres"])) return [];
        return array_column($detail["genres"], "name");
    }

    /** Lấy Trailer Key từ videos */
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

    /** Build URL ảnh */
    public function getPosterUrl(?string $path, string $size = "w500"): ?string
    {
        return $path ? "{$this->imgBase}{$size}{$path}" : null;
    }
}
