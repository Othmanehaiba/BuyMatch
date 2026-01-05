<?php

class Database
{
    private static ?PDO $pdo = null;

    private function __construct() {}

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host=localhost;dbname=buymatch;charset=utf8mb4";
            self::$pdo = new PDO($dsn, "root", "Root@123", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return self::$pdo;
    }
}