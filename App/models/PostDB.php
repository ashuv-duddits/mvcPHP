<?php
class PostDB extends CoreDB
{
    /**
     * @param post $post
     * @return int $postId
     */
    public static function savePost(post $post)
    {
        $message = $post->getMessage();
        $userId = $post->getUserId();
        $pdo = self::$pdo;
        $query = "INSERT INTO files (user_id, message) VALUES ($userId, :message);";
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute(['message' => $message]);
        if (!$ret) {
            print_r($pdo->errorInfo());
            die();
        }
        $postId = $pdo->lastInsertId();
        return $postId;
    }
}
