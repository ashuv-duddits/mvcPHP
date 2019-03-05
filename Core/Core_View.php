<?php
class Core_View
{
    private $templatePath;

    public function __construct($path = '')
    {
        $this->templatePath = $path;
    }

    public function setTemplatePath($path)
    {
        $this->templatePath = $path;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function render($tplName = '')
    {
        $tplFileName = $this->templatePath . DIRECTORY_SEPARATOR . $tplName;
        if (!file_exists(".." . DIRECTORY_SEPARATOR . $tplFileName)) {
            throw new Exception('Такого файла не существует');
        }
        ob_start(null, null, PHP_OUTPUT_HANDLER_STDFLAGS);
        require $tplFileName;
        return ob_get_clean();
    }
}