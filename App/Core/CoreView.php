<?php
//namespace App\Core;

class CoreView
{
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function render($requestController, $tplName = '')
    {
        $tplFileName = $this->getDefaultTemplatePath($requestController) . DIRECTORY_SEPARATOR . $tplName;
        if (!file_exists(".." . DIRECTORY_SEPARATOR . $tplFileName)) {
            throw new Exception('Такого файла не существует');
        }
        ob_start(null, null, PHP_OUTPUT_HANDLER_STDFLAGS);
        require $tplFileName;
        return ob_get_clean();
    }

    protected function getDefaultTemplatePath($requestController)
    {
        return 'App'
            . DIRECTORY_SEPARATOR
            . 'views'
            . DIRECTORY_SEPARATOR
            . strtolower($requestController);
    }
}