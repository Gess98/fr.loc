<?php

use Whoops\Handler\CallbackHandler;
use Whoops\Handler\PrettyPageHandler;

$start_framework = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Подключите PHP версии 8 и выше');
}

// Подключение файла с настройками
require_once __DIR__ ."/../config/config.php";
// Подключение автозагрузчик composer
require_once ROOT . "/vendor/autoload.php";
// Подключение файла с функциями хелперами
require_once HELPERS . "/helpers.php";
// Обработчик ошибок
$whoops =new \Whoops\Run;
if(DEBUG) {
    $whoops->pushHandler(new PrettyPageHandler());
}else {
    $whoops->pushHandler(new CallbackHandler(function (Throwable $e) {
        error_log("[" . date('Y-m-d H:i:s'). "] Error: {$e->getMessage()}" . PHP_EOL . "File: {$e->getFile()}" . PHP_EOL . 
        "Line: {$e->getLine()}" . PHP_EOL . '--------------------' . PHP_EOL, 3, ERROR_LOGS);
        abort('Some error', 500);
    }));
}
$whoops->register();

$app = new PHPFramework\Application();
// Подключение файла с маршрутами
require_once CONFIG . "/routes.php";
$app->run();

// dump("Time" . microtime(true) - $start_framework);