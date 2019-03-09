<?php
class UserDB  extends CoreDB
{
    /**
     * @param int $id
     * @return null|User
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
        return new User($userData);
    }
    /**
     * @param string $login
     * @return null|User
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
        return new User($userData);
    }
    /**
     * @param User $user
     */
    public static function saveUser(User $user)
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

    public static function getModels()
    {
        $pdo = self::$pdo;
        $query = "SELECT * FROM users;";
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute();
        if (!$ret) {
            print_r($pdo->errorInfo());
            die();
        }
        $usersData = $prepared->fetchAll(PDO::FETCH_ASSOC);
        if (!$usersData) {
            return null;
        }
        $users = [];
        foreach ($usersData as $userData) {
            $users[] = new User($userData);
        }
        return $users;
    }
}
