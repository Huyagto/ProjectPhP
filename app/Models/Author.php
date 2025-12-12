<?php
namespace Models;
use PDO;
class Author
{
    public static function all()
    {
        global $pdo;
        return $pdo->query("SELECT * FROM authors ORDER BY name ASC")->fetchAll();
    }

    public static function find($id)
    {
        global $pdo;
        $stm = $pdo->prepare("SELECT * FROM authors WHERE id=?");
        $stm->execute([$id]);
        return $stm->fetch();
    }
public static function search($keyword)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM authors WHERE name LIKE ?");
    $stmt->execute(["%$keyword%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Tạo author mới và trả về ID
    public static function create($name)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO authors (name) VALUES (?)");
        $stmt->execute([$name]);
        return $pdo->lastInsertId();
    }

    // Tìm theo tên → nếu không có thì tạo → trả về ID
    public static function firstOrCreate($name)
    {
        if (!$name) return null;

        global $pdo;

        // Tìm
        $stmt = $pdo->prepare("SELECT id FROM authors WHERE name = ?");
        $stmt->execute([$name]);
        $id = $stmt->fetchColumn();

        if ($id) return $id;

        // Tạo mới
        $stmt = $pdo->prepare("INSERT INTO authors (name) VALUES (?)");
        $stmt->execute([$name]);

        return $pdo->lastInsertId();
    }

    public static function update($id, $name)
    {
        global $pdo;
        return $pdo->prepare("UPDATE authors SET name=? WHERE id=?")->execute([$name, $id]);
    }

    public static function delete($id)
    {
        global $pdo;

        // Clear liên kết giữa movie và author
        $pdo->prepare("UPDATE movies SET author_id=NULL WHERE author_id=?")->execute([$id]);

        return $pdo->prepare("DELETE FROM authors WHERE id=?")->execute([$id]);
    }

    public static function count() {
        global $pdo;
        return $pdo->query("SELECT COUNT(*) FROM authors")->fetchColumn();
    }
}
