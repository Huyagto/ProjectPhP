<?php
namespace Models;

class BaseModel
{
    /** @var \PDO */
    protected static $pdo;
    public static function setPDO($pdo)
    {
        self::$pdo = $pdo;
    }
    public static function getPDO()
    {
        return self::$pdo;
    }
}
