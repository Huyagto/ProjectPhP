<?php
namespace Models;

class User {

    public static function all() {
        global $pdo;
        return $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function findByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function findByLogin($login) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$login, $login]);
        return $stmt->fetch();
    }

    public static function create($username, $email, $password, $role = "user") {
        global $pdo;

        $hashed = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password, role)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$username, $email, $hashed, $role]);
    }

    public static function update($id, $username, $email, $role) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE users SET username=?, email=?, role=? WHERE id=?");
        return $stmt->execute([$username, $email, $role, $id]);
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count()
    {
        global $pdo;
        return $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
