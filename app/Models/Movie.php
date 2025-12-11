<?php
namespace Models;

use PDO;

class Movie
{
    /* ============================
       LẤY TOÀN BỘ PHIM
       ============================ */
    public static function all()
    {
        global $pdo;

        $sql = "
            SELECT 
                m.*,
                a.name AS author_name,
                GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
            FROM movies m
            LEFT JOIN authors a ON m.author_id = a.id
            LEFT JOIN movie_category mc ON mc.movie_id = m.id
            LEFT JOIN categories c ON c.id = mc.category_id
            GROUP BY m.id
            ORDER BY m.id DESC
        ";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ============================
       LẤY 1 PHIM THEO ID
       ============================ */
    public static function find($id)
    {
        global $pdo;

        $sql = "
            SELECT 
                m.*,
                a.name AS author_name,
                GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
            FROM movies m
            LEFT JOIN authors a ON m.author_id = a.id
            LEFT JOIN movie_category mc ON mc.movie_id = m.id
            LEFT JOIN categories c ON c.id = mc.category_id
            WHERE m.id = ?
            GROUP BY m.id
        ";

        $stm = $pdo->prepare($sql);
        $stm->execute([$id]);

        return $stm->fetch(PDO::FETCH_ASSOC);
    }


    /* ============================
       PHIM LIÊN QUAN (cùng categories)
       ============================ */
    public static function getRelated($categoriesString, $excludeId)
    {
        global $pdo;

        // categoriesString = "Action, Drama"
        if (!$categoriesString) return [];

        $categories = explode(", ", $categoriesString);

        // Tạo placeholders ?, ?, ?
        $placeholders = implode(",", array_fill(0, count($categories), "?"));

        $sql = "
            SELECT DISTINCT m.*
            FROM movies m
            LEFT JOIN movie_category mc ON m.id = mc.movie_id
            LEFT JOIN categories c ON c.id = mc.category_id
            WHERE c.name IN ($placeholders)
            AND m.id != ?
            LIMIT 10
        ";

        $stm = $pdo->prepare($sql);

        $params = array_merge($categories, [$excludeId]);

        $stm->execute($params);

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ============================
       SEARCH MOVIE
       ============================ */
    public static function search($keyword)
    {
        global $pdo;

        $key = "%$keyword%";

        $sql = "
            SELECT 
                m.*,
                a.name AS author_name,
                GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
            FROM movies m
            LEFT JOIN authors a ON m.author_id = a.id
            LEFT JOIN movie_category mc ON mc.movie_id = m.id
            LEFT JOIN categories c ON c.id = mc.category_id
            WHERE m.title LIKE ? OR m.description LIKE ?
            GROUP BY m.id
        ";

        $stm = $pdo->prepare($sql);
        $stm->execute([$key, $key]);

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ============================
       Kiểm tra TMDB ID tồn tại
       ============================ */
    public static function existsWithTMDB($tmdb_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM movies WHERE tmdb_id = ?");
        $stmt->execute([$tmdb_id]);
        return $stmt->fetchColumn();
    }


    /* ============================
       Tạo movie từ TMDB
       ============================ */
    public static function createFromTMDB($detail, $tmdb_id, $author_id)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT INTO movies (tmdb_id, title, description, year, poster, author_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $tmdb_id,
            $detail["title"],
            $detail["overview"],
            substr($detail["release_date"] ?? "0000", 0, 4),
            $detail["poster_path"],
            $author_id
        ]);

        return $pdo->lastInsertId();
    }
    public static function count()
{
    global $pdo;

    $stmt = $pdo->query("SELECT COUNT(*) FROM movies");
    return (int)$stmt->fetchColumn();
}
}
