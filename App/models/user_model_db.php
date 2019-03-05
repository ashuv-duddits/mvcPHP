<?php
class user_model_db  extends Core_DB
{
    /**
     * @param int $id
     * @return null|user_model
     */
    public static function getModelById(int $id)
    {
        $pdo = self::$pdo;
        $query = "SELECT * FROM users WHERE id = '$id';";
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute();
        if (!$ret) {
            print_r($pdo->errorInfo());
            die();
        }
        $userData = $prepared->fetch(PDO::FETCH_ASSOC);
        if (!$userData) {
            return null;
        }
        return new user_model($userData);
    }
    /**
     * @param string $login
     * @return null|user_model
     */
    public static function getModelByLogin(string $login)
    {
        $pdo = self::$pdo;
        $query = "SELECT * FROM users WHERE login = :login;";
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute(['login' => $login]);
        if (!$ret) {
            print_r($pdo->errorInfo());
            die();
        }
        $userData = $prepared->fetch(PDO::FETCH_ASSOC);
        if (!$userData) {
            return null;
        }
        var_dump($userData);
        return new user_model($userData);
    }
    /**
     * @param user_model $user
     */
    public static function saveUser(user_model $user)
    {
        $login = $user->getLogin();
        $password = $user->getPassword();
        $pdo = self::$pdo;
        $query = "INSERT INTO users (`login`, `password`) VALUES (:login, '$password');";
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute(['login' => $login]);
        if (!$ret) {
            print_r($pdo->errorInfo());
            die();
        }
        $userId = $pdo->lastInsertId();
        return $userId;
    }
}
