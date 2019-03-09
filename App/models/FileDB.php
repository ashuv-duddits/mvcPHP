<?php
class FileDB extends CoreDB
{
    /**
     * @param int $id
     * @return null|file
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
        return new File($fileData);
    }

    /**
     * @param file $file
     */
    public static function updateFile(file $file)
    {
        $url = $file->getUrl();
        $id = $file->getId();
        $pdo = self::$pdo;
        $query = "UPDATE files SET url=:url WHERE id='$id';";
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute(['url' => $url]);
        if (!$ret) {
            print_r($pdo->errorInfo());
            die();
        }
    }

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
            $files[] = new File($fileData);
        }
        return $files;
    }
}