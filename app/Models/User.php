<?php
namespace Models;

use PDO;

class User extends BaseModel
{
    /* Lấy tất cả users */
    public static function all()
{
    return self::$pdo->query("
        SELECT id, username, email, role, display_name, avatar 
        FROM users ORDER BY id DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
}


    /* Tìm theo ID */
    public static function find($id)
    {
        $stm = self::$pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stm->execute([$id]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /* Cập nhật avatar */
    public static function updateAvatar($id, $avatar)
    {
        $stm = self::$pdo->prepare("UPDATE users SET avatar=? WHERE id=?");
        return $stm->execute([$avatar, $id]);
    }

    /* Tìm theo email */
    public static function findByEmail($email)
    {
        $stm = self::$pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stm->execute([$email]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateInfo($id, $display_name, $email)
    {
        $stm = self::$pdo->prepare("UPDATE users SET display_name=?, email=? WHERE id=?");
        return $stm->execute([$display_name, $email, $id]);
    }

    /* Login bằng username hoặc email */
    public static function findByLogin($login)
    {
        $stm = self::$pdo->prepare("
            SELECT * FROM users 
            WHERE username = ? OR email = ?
            LIMIT 1
        ");
        $stm->execute([$login, $login]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /* Kiểm tra email hoặc username có tồn tại */
    public static function exists($email, $username)
    {
        $stm = self::$pdo->prepare("
            SELECT id 
            FROM users 
            WHERE email=? OR username=?
            LIMIT 1
        ");
        $stm->execute([$email, $username]);
        return $stm->fetchColumn() ? true : false;
    }

    /* Tạo user mới */
    public static function create($username, $email, $password, $display_name, $role = "user")
    {
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        // Lấy avatar mặc định từ thư mục
        $defaultAvatars = glob(__DIR__ . "/../../public/assets/img/*.png");

        if (!$defaultAvatars || count($defaultAvatars) === 0) {
            $randomAvatar = "assets/img/default.png";
        } else {
            $file = $defaultAvatars[array_rand($defaultAvatars)];
            $randomAvatar = "assets/img/" . basename($file);
        }

        $stmt = self::$pdo->prepare("
            INSERT INTO users (username, email, display_name, password, role, avatar)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([$username, $email, $display_name, $hashed, $role, $randomAvatar]);

        return self::$pdo->lastInsertId();
    }

    /* Cập nhật thông tin user */
    public static function update($id, $username, $email, $display_name, $password, $role, $avatar = null)
    {
        if ($password) {
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            $sql = "UPDATE users 
                    SET username=?, email=?, display_name=?, password=?, role=?, avatar=?
                    WHERE id=?";
            $params = [$username, $email, $display_name, $hashed, $role, $avatar, $id];
        } else {
            $sql = "UPDATE users 
                    SET username=?, email=?, display_name=?, role=?, avatar=?
                    WHERE id=?";
            $params = [$username, $email, $display_name, $role, $avatar, $id];
        }

        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /* Tìm kiếm user */
    public static function search($keyword)
    {
        $stmt = self::$pdo->prepare("
            SELECT *
            FROM users
            WHERE username LIKE ? OR email LIKE ? OR display_name LIKE ?
        ");

        $stmt->execute(["%$keyword%", "%$keyword%", "%$keyword%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Cập nhật mật khẩu */
    public static function updatePassword($id, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);

        $stmt = self::$pdo->prepare("UPDATE users SET password=? WHERE id=?");
        return $stmt->execute([$hashed, $id]);
    }

    /* Xóa user */
    public static function delete($id)
    {
        // Xóa watchlist theo user → tránh dữ liệu rác
        self::$pdo->prepare("DELETE FROM watchlist WHERE user_id = ?")->execute([$id]);

        $stmt = self::$pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /* Kiểm tra mật khẩu nhập đúng không */
    public static function verifyPassword($plain, $hashed)
    {
        return password_verify($plain, $hashed);
    }

    /* Kiểm tra admin */
    public static function isAdmin($user)
    {
        return isset($user["role"]) && $user["role"] === "admin";
    }

    /* Đếm tổng số user */
    public static function count()
    {
        return self::$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
    public static function recent($limit = 6)
{
    $stmt = self::$pdo->prepare("
        SELECT *
        FROM users
        ORDER BY id DESC
        LIMIT ?
    ");

    $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}
