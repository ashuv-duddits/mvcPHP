<?php
header('Content-type: image/png');
$fileId = (int)$_GET['id'];
$url = realpath('images');
$data = file_get_contents($url . DIRECTORY_SEPARATOR . $fileId . '.png');
echo $data;
