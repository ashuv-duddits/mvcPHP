<?php
class Core_Dispatcher
{
    /** @var Base_Request */
    private $request;

    private $controllerName;
    private $actionName;

    public function __construct()
    {
        $this->request = Core_Context::getInstance()->getRequest();
    }
    public function dispatch()
    {
        $controller = strtolower($this->request->getRequestController());
        $action = strtolower($this->request->getRequestAction());

        $this->controllerName = $controller;
        $this->actionName = $action . 'Action';
    }
    /**
     * @return Core_Abstract_Controller
     */
    public function getController()
    {
        $controllerClassName =  $this->controllerName . '_controller';
        if (!class_exists($controllerClassName)) {
            throw new Exception('Controller ' . $controllerClassName . ' not found');
        }

        $controller = new $controllerClassName();
        if (!($controller instanceof Core_Abstract_Controller)) {
            throw new Exception('Controller ' . $controllerClassName . ' not implement abstract controller');
        }
        return $controller;
    }
    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }
}