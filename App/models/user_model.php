<?php
class user_model
{
    protected $id;
    protected $login;
    protected $password;

    public function __construct($userData)
    {
        $this->id = $userData['id'] ?? 0;
        $this->login = $userData['login'];
        $this->password = $userData['password'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }
}