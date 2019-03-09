<?php
//namespace App\Core;

abstract class BaseController
{
    /** @var CoreView */
    public $view;
    /** @var CoreSession */
    protected $session;

    protected function render($requestController, $tplName, $data = [])
    {
        foreach ($data as $key => $value) {
            //$this->view->files = $files;
            $this->view->{$key} = $value;
        }
        echo $this->view->render($requestController, $tplName.'.phtml');
    }

    public function __construct()
    {
        $this->view = new CoreView();
        $this->session = new CoreSession();
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit();
    }
}