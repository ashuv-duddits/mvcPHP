<?php
class users_model_db extends Core_DB
{

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
            $users[] = new user_model($userData);
        }
        return $users;
    }
}
