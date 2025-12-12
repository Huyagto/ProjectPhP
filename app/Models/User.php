<?php
namespace Models;
use PDO;

class User {

    /* Lấy tất cả users */
    public static function all() {
        global $pdo;
        return $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
    }

    /* Tìm theo ID */
    public static function find($id) {
        global $pdo;
        $stm = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stm->execute([$id]);
        return $stm->fetch();
    }

    /* Cập nhật avatar */
    public static function updateAvatar($id, $avatar)
{
    global $pdo;
    $stm = $pdo->prepare("UPDATE users SET avatar=? WHERE id=?");
    return $stm->execute([$avatar, $id]);
}


    /* Tìm theo email */
    public static function findByEmail($email) {
        global $pdo;
        $stm = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stm->execute([$email]);
        return $stm->fetch();
    }
public static function updateInfo($id, $display_name, $email)
{
    global $pdo;

    $stm = $pdo->prepare("UPDATE users SET display_name=?, email=? WHERE id=?");
    return $stm->execute([$display_name, $email, $id]);
}
    /* Login bằng username hoặc email */
    public static function findByLogin($login) {
        global $pdo;
        $stm = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stm->execute([$login, $login]);
        return $stm->fetch();
    }

    /* Kiểm tra tồn tại */
    public static function exists($email, $username) {
        global $pdo;
        $stm = $pdo->prepare("SELECT id FROM users WHERE email=? OR username=?");
        $stm->execute([$email, $username]);
        return $stm->fetchColumn() ? true : false;
    }

    /* Tạo user */
    public static function create($username, $email, $password, $display_name, $role = "user")
{
    global $pdo;

    $hashed = password_hash($password, PASSWORD_BCRYPT);

    // Lấy danh sách avatar mặc định
   // Lấy đúng đường dẫn avatar mặc định
// Quét đúng thư mục avatar
$defaultAvatars = glob(__DIR__ . "/../../public/assets/img/*.png");

// Nếu không có avatar → dùng một ảnh fallback
if (!$defaultAvatars || count($defaultAvatars) === 0) {
    $randomAvatar = "assets/img/default.png";
} else {
    // Chọn ảnh random
    $file = $defaultAvatars[array_rand($defaultAvatars)];

    // Lưu vào DB dạng tương đối (KHÔNG có public/)
    $randomAvatar = "assets/img/" . basename($file);
}



    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, display_name, password, role, avatar)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([$username, $email, $display_name, $hashed, $role, $randomAvatar]);

    return $pdo->lastInsertId();
}


    /* Update user */
    public static function update($id, $username, $email, $display_name, $password, $role, $avatar = null)
    {
        global $pdo;

        if ($password) { // Có đổi mật khẩu
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            $sql = "UPDATE users 
                    SET username=?, email=?, display_name=?, password=?, role=?, avatar=?
                    WHERE id=?";
            $params = [$username, $email, $display_name, $hashed, $role, $avatar, $id];

        } else { // Không đổi mật khẩu
            $sql = "UPDATE users 
                    SET username=?, email=?, display_name=?, role=?, avatar=?
                    WHERE id=?";
            $params = [$username, $email, $display_name, $role, $avatar, $id];
        }

        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /* Tìm kiếm */
    public static function search($keyword)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT * FROM users 
            WHERE username LIKE ? OR email LIKE ? OR display_name LIKE ?
        ");
        $stmt->execute(["%$keyword%", "%$keyword%", "%$keyword%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Update mật khẩu */
    public static function updatePassword($id, $newPassword) {
        global $pdo;

        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("UPDATE users SET password=? WHERE id=?");
        return $stmt->execute([$hashed, $id]);
    }

    /* Xóa user */
    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /* Kiểm tra mật khẩu */
    public static function verifyPassword($plain, $hashed) {
        return password_verify($plain, $hashed);
    }

    /* Check admin */
    public static function isAdmin($user) {
        return isset($user["role"]) && $user["role"] === "admin";
    }

    /* Đếm users */
    public static function count() {
        global $pdo;
        return $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
