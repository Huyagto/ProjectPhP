<?php
namespace Models;

use PDO;

class Author extends BaseModel
{
    public static function all()
    {
        return self::$pdo
            ->query("SELECT * FROM authors ORDER BY name ASC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM authors WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function search($keyword)
    {
        $stmt = self::$pdo->prepare("
            SELECT * FROM authors 
            WHERE name LIKE ?
        ");
        $stmt->execute(["%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($name)
    {
        $stmt = self::$pdo->prepare("INSERT INTO authors (name) VALUES (?)");
        $stmt->execute([$name]);

        return self::$pdo->lastInsertId();
    }

    public static function firstOrCreate($name)
    {
        if (!$name) return null;

        // kiểm tra tồn tại
        $stmt = self::$pdo->prepare("SELECT id FROM authors WHERE name = ?");
        $stmt->execute([$name]);

        $id = $stmt->fetchColumn();
        if ($id) return $id;

        // tạo mới
        return self::create($name);
    }

    public static function update($id, $name)
    {
        $stmt = self::$pdo->prepare("
            UPDATE authors 
            SET name = ?
            WHERE id = ?
        ");
        return $stmt->execute([$name, $id]);
    }

    public static function delete($id)
    {
        // Các phim có author này → set NULL
        self::$pdo->prepare("
            UPDATE movies 
            SET author_id = NULL 
            WHERE author_id = ?
        ")->execute([$id]);

        // Xóa tác giả
        $stmt = self::$pdo->prepare("DELETE FROM authors WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count()
    {
        return self::$pdo
            ->query("SELECT COUNT(*) FROM authors")
            ->fetchColumn();
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
