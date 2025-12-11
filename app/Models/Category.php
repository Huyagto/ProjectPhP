<?php
namespace Models;

class Category {

    public static function all() {
        global $pdo;
        return $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($name) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    public static function update($id, $name) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count() {
        global $pdo;
        return $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    }
}
