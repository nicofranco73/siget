<?php
// models/BaseModel.php
class BaseModel
{
    protected static $db;

    public function __construct()
    {
        if (!self::$db) {
            self::$db = require __DIR__ . '/../config/database.php';
        }
    }

    protected function db()
    {
        return self::$db;
    }
}