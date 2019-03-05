<?php
class Core_Application
{
    private $config;
    /** @var Core_Context */
    private $context;
    /** @var Core_Request */
    private $request;
    public function __construct($config)
    {
        $this->config = $config;
    }
    public function run()
    {
        try {
            Core_DB::init($this->config['db']);
            $this->context = Core_Context::getInstance();
            // это объект запроса, содержит все данные которые пришли от пользователя
            $this->request = new Core_Request();
            // помещаем его в контекст, он нам еще пригодится
            $this->context->setRequest($this->request);
            // обрабатываем пользовательский запрос
            $this->request->handle();
            // это диспетчер, он занимается обработкой запроса и получением нужного контроллера
            $dispatcher = new Core_Dispatcher();
            $dispatcher->dispatch();
            // просим диспетчер создать нам объект контроллера
            $controller = $dispatcher->getController();
            // получаем от диспетчера имя вызванного экшена
            $action = $dispatcher->getActionName();
            // проверяем существование метода
            if (!method_exists($controller, $action)) {
                throw new Exception(
                    'Action ' . $action . ' not found in controller '
                    . $this->request->getRequestController()
                );
            }
            // создаем view
            $view = new Core_View($this->getDefaultTemplatePath());
            // передаем созданный объект view в контроллер (теперь мы из контроллера можем им управлять)
            $controller->view = $view;
            // вызываем экшен
            $controller->$action();
            // рендерим контент
            $content = $view->render($controller->tpl);
            echo $content;
        } catch (Exception $e) {
            echo 'Произошло исключение: ' . $e->getMessage();
            // обработка исключений самого базового уровня - редирект на 404.html
        }
    }

    private function getDefaultTemplatePath()
    {
        return 'App'
            . DIRECTORY_SEPARATOR
            . 'views'
            . DIRECTORY_SEPARATOR
            . strtolower($this->request->getRequestController());
    }
}
