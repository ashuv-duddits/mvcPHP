<?php
//namespace App\controllers;

class UsersController extends BaseController
{
    public function indexAction($requestController)
    {
        $users = UserDB::getModels();
        $files = FileDB::getModels();
        return $this->render($requestController, 'index', ['users' => $users, 'files' => $files]);
    }
}