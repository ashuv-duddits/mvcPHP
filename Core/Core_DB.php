<?php
abstract class Core_DB
{
    protected static $pdo;

    public function __construct()
    {
        if (!self::$pdo) {
            throw new Exception('Нет объекта PDO');
        }
    }
    /**
     * @param mixed $config
     */
    public static function init($config)
    {
        try {
            $db_hostname = $config['db_hostname1']; // хост БД
            $db_database = $config['db_database']; // имя базы данных
            $db_username = $config['db_username']; // имя пользователя
            $db_password = $config['db_password']; // пароль
            $db_port = $config['db_port']; // порт
            self::$pdo = new PDO("mysql:dbname=$db_database;host=$db_hostname;port=$db_port", "$db_username", "$db_password");
        } catch (Exception $e) {
            die('Error: '.$e->getMessage());
        }
    }
}