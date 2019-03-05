<?php
class file_model_db extends Core_DB
{
    /**
     * @param int $id
     * @return null|file_model
     */
    public static function getModelById(int $id)
    {
        $pdo = self::$pdo;
        $query = "SELECT * FROM files WHERE id = '$id';";
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute();
        if (!$ret) {
            print_r($pdo->errorInfo());
            die();
        }
        $fileData = $prepared->fetch(PDO::FETCH_ASSOC);
        if (!$fileData) {
            return null;
        }
        return new file_model($fileData);
    }

    /**
     * @param file_model $file
     */
    public static function updateFile(file_model $file)
    {
        $url = $file->getUrl();
        $id = $file->getId();
        $pdo = self::$pdo;
        $query = "UPDATE files SET url='$url' WHERE id=:id;";
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute(['id' => $id]);
        if (!$ret) {
            print_r($pdo->errorInfo());
            die();
        }
    }
}