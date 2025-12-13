<?php
namespace Helpers;

class ImageHelper
{
    // Size TMDB hay dùng
    public const POSTER   = 'w500';
    public const BACKDROP = 'original';
    public const SMALL    = 'w300';

    /**
     * Xử lý ảnh movie (poster / backdrop)
     *
     * @param string|null $img   dữ liệu trong DB
     * @param string      $size  size TMDB
     * @return string            url hoàn chỉnh để render
     */
    public static function movie(?string $img, string $size = self::POSTER): string
    {
        // Ảnh fallback
        if (empty($img)) {
            return BASE_URL . '/assets/img/no-image.jpg';
        }

        // Đã là URL đầy đủ (TMDB full hoặc CDN)
        if (str_starts_with($img, 'http')) {
            return $img;
        }

        // Path TMDB (/abcxyz.jpg)
        if (str_starts_with($img, '/')) {
            return "https://image.tmdb.org/t/p/{$size}{$img}";
        }

        // Ảnh upload local
        return BASE_URL . "/uploads/" . $img;
    }

    /**
     * Poster movie
     */
    public static function poster(array $movie, string $size = self::POSTER): string
    {
        return self::movie($movie['poster'] ?? null, $size);
    }

    /**
     * Backdrop movie
     */
    public static function backdrop(array $movie, string $size = self::BACKDROP): string
    {
        return self::movie($movie['backdrop'] ?? null, $size);
    }
}
