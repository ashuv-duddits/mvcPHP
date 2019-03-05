<?php

ini_set('include_path',
    ini_get('include_path') . PATH_SEPARATOR .
    '../App'. PATH_SEPARATOR .
    '../App/controllers'. PATH_SEPARATOR .
    '../App/models'. PATH_SEPARATOR .
    '../Core'. PATH_SEPARATOR .
    '..'
);

//echo '<pre>' . print_r($_SERVER, 1);
//var_dump(ini_get('include_path'));

require 'init.php';
$app = new Core_Application($appConfig);
$app->run();
