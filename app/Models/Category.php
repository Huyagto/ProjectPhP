<?php
namespace Models;

class Category
{
    /**
     * Lấy tất cả category
     */
    public static function all()
    {
        global $pdo;
        return $pdo->query("SELECT * FROM categories ORDER BY id DESC")
                   ->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Tìm category theo id
     */
    public static function find($id)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Tạo 1 category mới
     */
    public static function create($name)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT INTO categories (name)
            VALUES (?)
        ");
        $stmt->execute([$name]);

        return $pdo->lastInsertId();
    }

    /**
     * Cập nhật category
     */
    public static function update($id, $name)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            UPDATE categories
            SET name = ?
            WHERE id = ?
        ");
        return $stmt->execute([$name, $id]);
    }

    /**
     * Xoá category & xoá luôn liên kết với movie_category
     */
    public static function delete($id)
    {
        global $pdo;

        // Xoá liên kết trong bảng pivot
        $pdo->prepare("DELETE FROM movie_category WHERE category_id = ?")
            ->execute([$id]);

        // Xoá category
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Tìm category theo tên – nếu không có thì tạo mới
     */
    public static function findOrCreate($name)
    {
        global $pdo;

        // Tìm tồn tại
        $stmt = $pdo->prepare("SELECT id FROM categories WHERE name = ?");
        $stmt->execute([$name]);

        $id = $stmt->fetchColumn();
        if ($id) return $id;

        // Không có → tạo mới
        return self::create($name);
    }

    /**
     * Tạo nhiều category (nếu chưa tồn tại)
     */
    public static function createManyIfNotExist($names)
    {
        $ids = [];
        foreach ($names as $name) {
            $ids[] = self::findOrCreate($name);
        }
        return $ids;
    }

    /**
     * Tìm kiếm category theo name
     */
    public static function search($keyword)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT * FROM categories
            WHERE name LIKE ?
            ORDER BY id DESC
        ");

        $stmt->execute(["%" . $keyword . "%"]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số category
     */
    public static function count()
    {
        global $pdo;
        return $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    }
}
