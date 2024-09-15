<?php

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

$app = new PHPFramework\Application();
// Подключение файла с маршрутами
require_once CONFIG . "/routes.php";
$app->run();


// dump($app->request->getMethod());
// dump($app->request->isAjax());
// dump($app->request->get('page', 10));
// dump(request()->get('page'));

dump("Time" . microtime(true) - $start_framework);