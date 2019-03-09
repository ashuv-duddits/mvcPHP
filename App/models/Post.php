<?php
class Post
{
    protected $id;
    protected $user_id;
    protected $message;

    public function __construct($userData)
    {
        $this->id = $userData['id'] ?? 0;
        $this->user_id = $userData['user_id'];
        $this->message = $userData['message'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
