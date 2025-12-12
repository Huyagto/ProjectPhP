<?php
namespace Models;

class BaseModel
{
    /** @var \PDO */
    protected static $pdo;

    // Gán PDO cho tất cả Model (gọi từ config/db.php)
    public static function setPDO($pdo)
    {
        self::$pdo = $pdo;
    }

    // Cho phép Service lấy PDO an toàn
    public static function getPDO()
    {
        return self::$pdo;
    }
}
