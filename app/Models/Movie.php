<?php
namespace Models;

class Movie
{
    /* ============================
       LẤY DANH SÁCH PHIM + AUTHORS + CATEGORIES
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

        return $pdo->query($sql)->fetchAll();
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

        return $stm->fetch();
    }

    /* ============================
       CREATE MOVIE
       ============================ */
    public static function create($title, $description, $year, $poster, $author_id)
    {
        global $pdo;

        $stm = $pdo->prepare("
            INSERT INTO movies (title, description, year, poster, author_id)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stm->execute([$title, $description, $year, $poster, $author_id]);

        return $pdo->lastInsertId();
    }

    /* ============================
       UPDATE MOVIE
       ============================ */
    public static function update($id, $title, $description, $year, $poster, $author_id)
    {
        global $pdo;

        if ($poster) {
            $sql = "UPDATE movies SET title=?, description=?, year=?, poster=?, author_id=? WHERE id=?";
            return $pdo->prepare($sql)->execute([$title, $description, $year, $poster, $author_id, $id]);
        } else {
            $sql = "UPDATE movies SET title=?, description=?, year=?, author_id=? WHERE id=?";
            return $pdo->prepare($sql)->execute([$title, $description, $year, $author_id, $id]);
        }
    }

    /* ============================
       DELETE
       ============================ */
    public static function delete($id)
    {
        global $pdo;

        // xóa liên kết categories
        $pdo->prepare("DELETE FROM movie_category WHERE movie_id = ?")->execute([$id]);

        return $pdo->prepare("DELETE FROM movies WHERE id = ?")->execute([$id]);
    }

    /* ============================
       LẤY CATEGORY CỦA 1 MOVIE
       ============================ */
    public static function getCategories($movie_id)
    {
        global $pdo;

        $sql = "
            SELECT c.*
            FROM categories c
            JOIN movie_category mc ON c.id = mc.category_id
            WHERE mc.movie_id = ?
        ";

        $stm = $pdo->prepare($sql);
        $stm->execute([$movie_id]);

        return $stm->fetchAll();
    }

    /* ============================
       SEARCH
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
            ORDER BY m.id DESC
        ";

        $stm = $pdo->prepare($sql);
        $stm->execute([$key, $key]);

        return $stm->fetchAll();
    }

    /* ============================
       GÁN CATEGORY CHO MOVIE
       ============================ */
    public static function syncCategories($movie_id, $category_ids)
    {
        global $pdo;

        $pdo->prepare("DELETE FROM movie_category WHERE movie_id=?")->execute([$movie_id]);

        $stm = $pdo->prepare("INSERT INTO movie_category (movie_id, category_id) VALUES (?, ?)");

        foreach ($category_ids as $cat_id) {
            $stm->execute([$movie_id, $cat_id]);
        }
    }

    /* ============================
       COUNT MOVIE
       ============================ */
    public static function count()
    {
        global $pdo;
        return $pdo->query("SELECT COUNT(*) FROM movies")->fetchColumn();
    }

    /* ============================
       TMDB AUTO FETCH (Full: movie + author + genres)
       ============================ */
    public static function autoFetchFullFromTMDB()
    {
        global $pdo;

        $apiKey = "af69a70274d4ddc4b8bd3ce03b195744";
        $url = "https://api.themoviedb.org/3/movie/popular?api_key=$apiKey&language=vi-VN&page=1";

        $json = @file_get_contents($url);
        if (!$json) return;

        $data = json_decode($json, true);
        if (!isset($data["results"])) return;

        foreach ($data["results"] as $movie) {

            $tmdb_id = $movie["id"];

            // Kiểm tra trùng
            $check = $pdo->prepare("SELECT id FROM movies WHERE tmdb_id=? LIMIT 1");
            $check->execute([$tmdb_id]);

            if ($check->fetch()) continue;

            // Lấy chi tiết phim
            $detail = json_decode(@file_get_contents(
                "https://api.themoviedb.org/3/movie/$tmdb_id?api_key=$apiKey&language=vi-VN"
            ), true);

            // Lấy credit để tìm đạo diễn
            $credits = json_decode(@file_get_contents(
                "https://api.themoviedb.org/3/movie/$tmdb_id/credits?api_key=$apiKey"
            ), true);

            // Tìm director
            $director = null;
            if (!empty($credits["crew"])) {
                foreach ($credits["crew"] as $c) {
                    if ($c["job"] === "Director") {
                        $director = $c["name"];
                        break;
                    }
                }
            }

            // Insert author nếu chưa có
            $author_id = null;
            if ($director) {
                $stmt = $pdo->prepare("SELECT id FROM authors WHERE name=? LIMIT 1");
                $stmt->execute([$director]);
                $exist = $stmt->fetchColumn();

                if ($exist) {
                    $author_id = $exist;
                } else {
                    $pdo->prepare("INSERT INTO authors (name) VALUES (?)")->execute([$director]);
                    $author_id = $pdo->lastInsertId();
                }
            }

            // Insert movie
            $pdo->prepare("
                INSERT INTO movies (tmdb_id, title, description, year, poster, author_id)
                VALUES (?, ?, ?, ?, ?, ?)
            ")
            ->execute([
                $tmdb_id,
                $detail["title"] ?? "",
                $detail["overview"] ?? "",
                substr($detail["release_date"] ?? "0000", 0, 4),
                $detail["poster_path"] ?? null,
                $author_id
            ]);

            $movie_id = $pdo->lastInsertId();

            // Gán categories (genres)
            if (!empty($detail["genres"])) {
                foreach ($detail["genres"] as $g) {

                    // Tìm category
                    $stmt = $pdo->prepare("SELECT id FROM categories WHERE name=?");
                    $stmt->execute([$g["name"]]);
                    $cat_id = $stmt->fetchColumn();

                    if (!$cat_id) {
                        $pdo->prepare("INSERT INTO categories (name) VALUES (?)")->execute([$g["name"]]);
                        $cat_id = $pdo->lastInsertId();
                    }

                    $pdo->prepare("INSERT INTO movie_category (movie_id, category_id) VALUES (?, ?)")
                        ->execute([$movie_id, $cat_id]);
                }
            }
        }
    }
    public static function existsWithTMDB($tmdb_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM movies WHERE tmdb_id = ?");
    $stmt->execute([$tmdb_id]);
    return $stmt->fetchColumn();
}

public static function createFromTMDB($detail, $tmdb_id, $author_id) {
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

}
