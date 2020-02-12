<?php
$rootPath = realpath(__DIR__ .'/..');
require $rootPath .'/vendor/autoload.php';

$application = new \App\Application($rootPath);
$application->run();
