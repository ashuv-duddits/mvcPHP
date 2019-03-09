<?php

ini_set('include_path',
    ini_get('include_path') . PATH_SEPARATOR .
    '../App'. PATH_SEPARATOR .
    '../App/Core'. PATH_SEPARATOR .
    '../App/controllers'. PATH_SEPARATOR .
    '../App/models'. PATH_SEPARATOR .
    '..'
);

require 'init.php';
try {
    $app = new Application($appConfig);
    $app->run();
} catch (Exception $e) {
    echo 'Произошло исключение: ' . $e->getMessage();
}
