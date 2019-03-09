<?php
//namespace App\Core;

abstract class CoreDB
{
    protected static $pdo;
    /**
     * @param mixed $config
     */
    public static function init($config)
    {
        $db_hostname = $config['db_hostname']; // хост БД
        $db_database = $config['db_database']; // имя базы данных
        $db_username = $config['db_username']; // имя пользователя
        $db_password = $config['db_password']; // пароль
        $db_port = $config['db_port']; // порт
        if (!self::$pdo) {
            self::$pdo = new PDO("mysql:dbname=$db_database;host=$db_hostname;port=$db_port", "$db_username", "$db_password");
        }
    }
}
