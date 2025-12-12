<?php
namespace Models;

use PDO;

class Movie extends BaseModel
{
    public static function all()
    {
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

        return self::$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
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

        $stm = self::$pdo->prepare($sql);
        $stm->execute([$id]);

        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public static function search($keyword)
    {
        $sql = "
            SELECT 
                m.*, 
                a.name AS author_name,
                GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
            FROM movies m
            LEFT JOIN authors a ON m.author_id = a.id
            LEFT JOIN movie_category mc ON mc.movie_id = m.id
            LEFT JOIN categories c ON c.id = mc.category_id
            WHERE m.title LIKE ?
            GROUP BY m.id
            ORDER BY m.id DESC
        ";

        $stm = self::$pdo->prepare($sql);
        $stm->execute(["%$keyword%"]);

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($title, $desc, $year, $poster, $author_id)
    {
        $stmt = self::$pdo->prepare("
            INSERT INTO movies (title, description, year, poster, author_id)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([$title, $desc, $year, $poster, $author_id]);

        return self::$pdo->lastInsertId();
    }

    public static function update($id, $title, $desc, $year, $poster, $author_id)
    {
        if ($poster) {
            $sql = "
                UPDATE movies 
                SET title = ?, description = ?, year = ?, poster = ?, author_id = ?
                WHERE id = ?
            ";
            $params = [$title, $desc, $year, $poster, $author_id, $id];
        } else {
            $sql = "
                UPDATE movies 
                SET title = ?, description = ?, year = ?, author_id = ?
                WHERE id = ?
            ";
            $params = [$title, $desc, $year, $author_id, $id];
        }

        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete($id)
    {
        self::$pdo->prepare("DELETE FROM movie_category WHERE movie_id = ?")
                  ->execute([$id]);

        $stmt = self::$pdo->prepare("DELETE FROM movies WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getCategories($movie_id)
    {
        $stmt = self::$pdo->prepare("
            SELECT category_id
            FROM movie_category
            WHERE movie_id = ?
        ");

        $stmt->execute([$movie_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_column($rows, "category_id");
    }

    public static function syncCategories($movie_id, $category_ids)
    {
        self::$pdo->prepare("DELETE FROM movie_category WHERE movie_id = ?")
                  ->execute([$movie_id]);

        if (empty($category_ids)) return;

        $stmt = self::$pdo->prepare("
            INSERT INTO movie_category (movie_id, category_id)
            VALUES (?, ?)
        ");

        foreach ($category_ids as $cid) {
            $stmt->execute([$movie_id, (int)$cid]);
        }
    }

    public static function existsWithTMDB($tmdb_id)
    {
        $stmt = self::$pdo->prepare("SELECT id FROM movies WHERE tmdb_id = ?");
        $stmt->execute([$tmdb_id]);
        return $stmt->fetchColumn();
    }

    public static function createFromTMDB($data)
    {
        $stmt = self::$pdo->prepare("
            INSERT INTO movies 
                (tmdb_id, title, description, year, release_date, poster, backdrop, rating, duration, trailer, author_id, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $data["tmdb_id"] ?? null,
            $data["title"] ?? null,
            $data["overview"] ?? null,
            $data["year"] ?? null,
            $data["release_date"] ?? null,
            $data["poster"] ?? null,
            $data["backdrop"] ?? null,
            $data["rating"] ?? null,
            $data["duration"] ?? null,
            $data["trailer"] ?? null,
            $data["author_id"] ?? null
        ]);

        return self::$pdo->lastInsertId();
    }

    public static function getRelated($categoriesString, $excludeId, $limit = 10)
    {
        if (!$categoriesString) return [];

        $categories = array_map("trim", explode(",", $categoriesString));
        $placeholders = implode(",", array_fill(0, count($categories), "?"));

        $sql = "
            SELECT DISTINCT m.*
            FROM movies m
            LEFT JOIN movie_category mc ON m.id = mc.movie_id
            LEFT JOIN categories c ON c.id = mc.category_id
            WHERE c.name IN ($placeholders)
            AND m.id != ?
            LIMIT ?
        ";

        $stmt = self::$pdo->prepare($sql);

        $params = array_merge($categories, [$excludeId, $limit]);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function count()
    {
        return self::$pdo->query("SELECT COUNT(*) FROM movies")->fetchColumn();
    }

    public static function createFull($title, $desc, $year, $poster, $backdrop, $author_id)
    {
        $stmt = self::$pdo->prepare("
            INSERT INTO movies (title, description, year, poster, backdrop, author_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([$title, $desc, $year, $poster, $backdrop, $author_id]);

        return self::$pdo->lastInsertId();
    }

    public static function filter($search, $category, $author, $year)
    {
        $sql = "
            SELECT m.*, a.name AS author_name,
                   GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
            FROM movies m
            LEFT JOIN authors a ON a.id = m.author_id
            LEFT JOIN movie_category mc ON mc.movie_id = m.id
            LEFT JOIN categories c ON c.id = mc.category_id
            WHERE 1
        ";

        $params = [];

        if ($search) {
            $sql .= " AND m.title LIKE ? ";
            $params[] = "%$search%";
        }

        if ($author) {
            $sql .= " AND m.author_id = ? ";
            $params[] = $author;
        }

        if ($year) {
            $sql .= " AND m.year = ? ";
            $params[] = $year;
        }

        if ($category) {
            $sql .= " AND mc.category_id = ? ";
            $params[] = $category;
        }

        $sql .= " GROUP BY m.id ORDER BY m.id DESC ";

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateFull($id, $data)
{
    $current = self::find($id);

    $title        = $data["title"]        ?? $current["title"];
    $description  = $data["description"]  ?? $current["description"];
    $year         = $data["year"]         ?? $current["year"];
    $release_date = $data["release_date"] ?? $current["release_date"];
    $poster       = $data["poster"]       ?? $current["poster"];
    $backdrop     = $data["backdrop"]     ?? $current["backdrop"];
    $author_id    = $data["author_id"]    ?? $current["author_id"];
    $rating       = $data["rating"]       ?? $current["rating"];
    $duration     = $data["duration"]     ?? $current["duration"];
    $trailer      = $data["trailer"]      ?? $current["trailer"];

    $sql = "
        UPDATE movies
        SET 
            title = ?, 
            description = ?, 
            year = ?, 
            release_date = ?, 
            poster = ?, 
            backdrop = ?, 
            author_id = ?, 
            rating = ?, 
            duration = ?, 
            trailer = ?
        WHERE id = ?
    ";

    $stmt = self::$pdo->prepare($sql);

    return $stmt->execute([
        $title,
        $description,
        $year,
        $release_date,
        $poster,
        $backdrop,
        $author_id,
        $rating,
        $duration,
        $trailer,
        $id
    ]);
}

    public static function recent($limit = 6)
{
    $stmt = self::$pdo->prepare("
        SELECT *
        FROM movies
        ORDER BY id DESC
        LIMIT ?
    ");
    $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}
