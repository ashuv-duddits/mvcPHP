<?php
class Core_Request
{
    const DEFAULT_CONTROLLER = 'index';
    const DEFAULT_ACTION = 'index';

    private $requestController;
    private $requestAction;
    private $requestParams;
    private $requestUri;

    public function __construct()
    {
        $this->requestParams = $_REQUEST;
        $this->requestUri = trim($_SERVER['REQUEST_URI'], '/');
    }
    /**
     * @throws Exception
     *
     * Метод обрабатывает пользовательский запрос
     * Валидирует переданный модуль, контроллер и экшен
     * Заполняет соответствующие переменные для будущего создания объекта контроллера
     */
    public function handle()
    {
        $parts = explode('/', $this->requestUri);

        if (!$parts || sizeof($parts) < 2) {
            $this->requestController = self::DEFAULT_CONTROLLER;
            $this->requestAction = self::DEFAULT_ACTION;
        } else {
            foreach ($parts as $k => $part) {
                if (!$this->validate($part)) {
                    throw new Exception('Url part #' . $k . ' not valid: ' . $part);
                }
            }

            $this->requestController = $parts[0] ?? self::DEFAULT_CONTROLLER;
            $this->requestAction = explode('?', $parts[1])[0] ?? self::DEFAULT_ACTION;
        }
    }

    private function validate($urlPart)
    {
        $ret = preg_match('/^[a-zA-Z0-9?=&]+$/', $urlPart);
        return $ret;
    }

    /**
     * @return mixed
     */
    public function getRequestController()
    {
        return $this->requestController;
    }

    /**
     * @return mixed
     */
    public function getRequestAction()
    {
        return $this->requestAction;
    }

    /**
     * @return mixed
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }

    /**
     * @return mixed
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }
}