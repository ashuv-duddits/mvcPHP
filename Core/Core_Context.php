<?php
class Core_Context
{
    private $request;
    private static $instance;

    private function __construct()
    {
        //Приватный конструктор нужен для того чтобы нельзя было создать объект этого класс
    }

    private function __clone()
    {
        //Клонировать тоже нельзя
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * @return Core_Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}