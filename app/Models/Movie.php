<?php
namespace Models;

use PDO;

class Movie
{
    /**
     * Lấy toàn bộ movie (kèm author name + danh sách categories dưới dạng chuỗi)
     */
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

    /**
     * Tìm movie theo id (chi tiết)
     */
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

    /**
     * Tìm kiếm theo tiêu đề (dùng trong listing admin)
     */
    public static function search($keyword)
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
            WHERE m.title LIKE ?
            GROUP BY m.id
            ORDER BY m.id DESC
        ";

        $stm = $pdo->prepare($sql);
        $stm->execute(['%' . $keyword . '%']);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo movie mới (trả về movie_id)
     */
    public static function create($title, $desc, $year, $poster, $author_id)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT INTO movies (title, description, year, poster, author_id)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([$title, $desc, $year, $poster, $author_id]);

        return $pdo->lastInsertId();
    }

    /**
     * Cập nhật movie
     * Nếu $poster = null => giữ poster cũ
     */
    public static function update($id, $title, $desc, $year, $poster, $author_id)
    {
        global $pdo;

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

        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Xóa movie (cùng với liên kết movie_category)
     */
    public static function delete($id)
    {
        global $pdo;

        // xóa quan hệ pivot trước
        $pdo->prepare("DELETE FROM movie_category WHERE movie_id = ?")
            ->execute([$id]);

        // xóa movie
        $stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Lấy mảng category_id của movie
     * Trả về dạng [1, 2, 5] hoặc [] nếu không có
     */
public static function getCategories($movie_id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT category_id
        FROM movie_category
        WHERE movie_id = ?
    ");
    $stmt->execute([$movie_id]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_column($rows, "category_id");
}



    /**
     * Đồng bộ categories: xóa các category cũ, chèn category mới
     * Nhận $category_ids là mảng (có thể rỗng)
     */
    public static function syncCategories($movie_id, $category_ids)
    {
        global $pdo;

        // Xóa tất cả liên kết cũ
        $pdo->prepare("DELETE FROM movie_category WHERE movie_id = ?")
            ->execute([$movie_id]);

        // Nếu không có category mới thì dừng
        if (empty($category_ids)) {
            return;
        }

        // Thêm mới (prepared once for performance)
        $stmt = $pdo->prepare("
            INSERT INTO movie_category (movie_id, category_id)
            VALUES (?, ?)
        ");

        foreach ($category_ids as $cid) {
            // ensure integer
            $stmt->execute([$movie_id, (int)$cid]);
        }
    }

    /**
     * Kiểm tra tồn tại theo tmdb_id (dùng khi import từ TMDB)
     * Trả về id nếu tồn tại, false/null nếu không
     */
    public static function existsWithTMDB($tmdb_id)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT id FROM movies WHERE tmdb_id = ?");
        $stmt->execute([$tmdb_id]);
        return $stmt->fetchColumn();
    }

    /**
     * Tạo movie từ dữ liệu TMDB (dùng khi import)
     * Trả về new movie id
     * $data phải chứa keys tương ứng: tmdb_id, title, overview, year, release_date, poster, backdrop, rating, duration, trailer, author_id
     */
    public static function createFromTMDB($data)
    {
        global $pdo;

        $stmt = $pdo->prepare("
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

        return $pdo->lastInsertId();
    }

    /**
     * Lấy movie liên quan theo tên categories (trả về tối đa limit)
     * $categoriesString là chuỗi ví dụ "Action, Comedy"
     */
    public static function getRelated($categoriesString, $excludeId, $limit = 10)
    {
        global $pdo;

        if (!$categoriesString) return [];

        $categories = array_map('trim', explode(",", $categoriesString));
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

        $stm = $pdo->prepare($sql);
        $params = array_merge($categories, [$excludeId, $limit]);
        $stm->execute($params);

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function count()
{
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM movies")->fetchColumn();
}
public static function createFull($title, $desc, $year, $poster, $backdrop, $author_id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO movies (title, description, year, poster, backdrop, author_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([$title, $desc, $year, $poster, $backdrop, $author_id]);

    return $pdo->lastInsertId();
}

public static function filter($search, $category, $author, $year)
{
    global $pdo;

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

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

public static function updateFull($id, $title, $desc, $year, $poster, $backdrop, $author_id)
{
    global $pdo;

    // Nếu không upload ảnh mới thì giữ ảnh cũ
    $current = self::find($id);

    if (!$poster)   $poster   = $current['poster'];
    if (!$backdrop) $backdrop = $current['backdrop'];

    $stmt = $pdo->prepare("
        UPDATE movies 
        SET title = ?, description = ?, year = ?, poster = ?, backdrop = ?, author_id = ?
        WHERE id = ?
    ");

    return $stmt->execute([$title, $desc, $year, $poster, $backdrop, $author_id, $id]);
}

}
