<?php
//namespace App\Core;

class Application
{
    const DEFAULT_CONTROLLER = 'index';
    const DEFAULT_ACTION = 'index';
    private $requestParams;
    private $requestUri;
    private $requestController;
    private $controllerName;
    private $actionName;

    public function __construct($config)
    {
        CoreDB::init($config['db']);
    }
    public function run()
    {
        // сохраняем пользовательский запрос
        $this->requestParams = $_REQUEST;
        $this->requestUri = trim($_SERVER['REQUEST_URI'], '/');
        // обрабатываем пользовательский запрос
        $this->handle();

        // проверяем существование класса контроллера
        if (!class_exists($this->controllerName)) {
            throw new Exception('Controller ' . $this->controllerName . ' not found');
        }

        // создаем контроллер
        $controller = new $this->controllerName();
        if (!($controller instanceof BaseController)) {
            throw new Exception('Controller ' . $this->controllerName . ' not implement abstract controller');
        }

        // проверяем существование метода
        if (!method_exists($this->controllerName, $this->actionName)) {
            throw new Exception(
                'Action ' . $this->actionName . ' not found in controller '
                . $this->controllerName
            );
        }
        // вызываем экшен
        $action = $this->actionName;
        $controller->$action($this->requestController);
    }

    private function handle()
    {
        $parts = explode('/', $this->requestUri);

        if (!$parts || sizeof($parts) < 2) {
            $this->requestController = self::DEFAULT_CONTROLLER;
            $requestAction = self::DEFAULT_ACTION;
            $this->controllerName =  $this->requestController . 'Controller';
            $this->actionName = $requestAction . 'Action';
        } else {
            foreach ($parts as $k => $part) {
                if (!$this->validate($part)) {
                    throw new Exception('Url part #' . $k . ' not valid: ' . $part);
                }
            }
            $requestController = $parts[0] ?? self::DEFAULT_CONTROLLER;
            $this->requestController = $requestController;
            $requestAction = explode('?', $parts[1])[0] ?? self::DEFAULT_ACTION;
            $this->controllerName =  $requestController . 'Controller';
            $this->actionName = $requestAction . 'Action';
        }
    }

    private function validate($urlPart)
    {
        $ret = preg_match('/^[a-zA-Z0-9?=&]+$/', $urlPart);
        return $ret;
    }

}
