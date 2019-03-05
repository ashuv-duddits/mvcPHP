<?php
class users_controller extends Core_Abstract_Controller
{
    public function indexAction()
    {
        $users = users_model_db::getModels();
        $this->view->users = $users;
        $files = files_model_db::getModels();
        $this->view->files = $files;
    }
}