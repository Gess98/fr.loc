<?php

// Возвращаеты экземпляр класса Application
function app(): PHPFramework\Application 
{
    return \PHPFramework\Application::$app;
}

// Возвращает экземпляр класса Request
function request(): PHPFramework\Request
{
    return app()->request;
}

// Возвращает экземпляр класса Response
function response(): PHPFramework\Response
{
    return app()->response;
}

// Возвращает экземпляр класса View или применяет метод render класса View
function view($view = '', $data = [], $layout = ''): string |\PHPFramework\View
{
    if($view) {
        return app()->view->render($view, $data, $layout);
    }
    return app()->view;
}

// Возвращает экземпляр класса Request
function abort($error = '', $code = '404') 
{
    response()->setResponseCode($code);
    echo view("errors/{$code}", ['error' => $error], false);
    die;
}

// Возвращает путь к файлу
function base_url($path = ''):string
{
    return PATH . $path;
}

