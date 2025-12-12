<?php
namespace Models;

use PDO;

class Watchlist extends BaseModel
{
    /* Thêm phim vào watchlist (tự động bỏ qua nếu đã có) */
    public static function add($user_id, $movie_id)
    {
        if (self::exists($user_id, $movie_id)) {
            return true; // Đã tồn tại -> không thêm nữa
        }

        $stmt = self::$pdo->prepare("
            INSERT INTO watchlist (user_id, movie_id)
            VALUES (?, ?)
        ");

        return $stmt->execute([$user_id, $movie_id]);
    }

    /* Kiểm tra đã tồn tại hay chưa */
    public static function exists($user_id, $movie_id)
    {
        $stmt = self::$pdo->prepare("
            SELECT id 
            FROM watchlist 
            WHERE user_id = ? AND movie_id = ?
            LIMIT 1
        ");
        $stmt->execute([$user_id, $movie_id]);

        return $stmt->fetchColumn() ? true : false;
    }

    /* Lấy danh sách phim user đã lưu (không có categories) */
    public static function getByUser($user_id)
    {
        $stmt = self::$pdo->prepare("
            SELECT m.* 
            FROM watchlist w
            JOIN movies m ON m.id = w.movie_id
            WHERE w.user_id = ?
            ORDER BY w.id DESC
        ");

        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Lấy watchlist chi tiết (gồm categories) */
    public static function getFullByUser($user_id)
    {
        $sql = "
            SELECT 
                m.*, 
                GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ', ') AS categories
            FROM watchlist w
            JOIN movies m ON m.id = w.movie_id
            LEFT JOIN movie_category mc ON mc.movie_id = m.id
            LEFT JOIN categories c ON c.id = mc.category_id
            WHERE w.user_id = ?
            GROUP BY m.id
            ORDER BY w.id DESC
        ";

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Xóa một phim khỏi watchlist */
    public static function delete($user_id, $movie_id)
    {
        $stmt = self::$pdo->prepare("
            DELETE FROM watchlist 
            WHERE user_id = ? AND movie_id = ?
        ");

        return $stmt->execute([$user_id, $movie_id]);
    }

    /* Toggle (thêm nếu chưa có, xóa nếu đã có) */
    public static function toggle($user_id, $movie_id)
    {
        if (self::exists($user_id, $movie_id)) {
            self::delete($user_id, $movie_id);
            return "removed";
        } else {
            self::add($user_id, $movie_id);
            return "added";
        }
    }
}
