<?php
include 'config.php';

spl_autoload_register('_autoload', true, false);
function _autoload($className)
{
    $file = $className . '.php';
    include $file;
}