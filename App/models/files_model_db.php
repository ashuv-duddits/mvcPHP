<?php

class files_model_db extends Core_DB
{
    public static function getModels()
    {
        $pdo = self::$pdo;
        $query = "SELECT * FROM files;";
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute();
        if (!$ret) {
            print_r($pdo->errorInfo());
            die();
        }
        $filesData = $prepared->fetchAll(PDO::FETCH_ASSOC);
        if (!$filesData) {
            return null;
        }
        $files = [];
        foreach ($filesData as $fileData) {
            $files[] = new file_model($fileData);
        }
        return $files;
    }
}