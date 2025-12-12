<?php
namespace Models;

use PDO;

class Category extends BaseModel
{
    public static function all()
    {
        return self::$pdo->query("SELECT * FROM categories ORDER BY id DESC")
                         ->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name)
    {
        $stmt = self::$pdo->prepare("
            INSERT INTO categories (name)
            VALUES (?)
        ");
        $stmt->execute([$name]);

        return self::$pdo->lastInsertId();
    }

    public static function update($id, $name)
    {
        $stmt = self::$pdo->prepare("
            UPDATE categories
            SET name = ?
            WHERE id = ?
        ");

        return $stmt->execute([$name, $id]);
    }

    public static function delete($id)
    {
        self::$pdo->prepare("DELETE FROM movie_category WHERE category_id = ?")
                  ->execute([$id]);

        $stmt = self::$pdo->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function findOrCreate($name)
    {
        $stmt = self::$pdo->prepare("SELECT id FROM categories WHERE name = ?");
        $stmt->execute([$name]);

        $id = $stmt->fetchColumn();
        if ($id) return $id;

        return self::create($name);
    }

    public static function createManyIfNotExist($names)
    {
        $ids = [];
        foreach ($names as $name) {
            $ids[] = self::findOrCreate($name);
        }
        return $ids;
    }

    public static function search($keyword)
    {
        $stmt = self::$pdo->prepare("
            SELECT *
            FROM categories
            WHERE name LIKE ?
            ORDER BY id DESC
        ");

        $stmt->execute(["%" . $keyword . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function count()
    {
        return self::$pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
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
