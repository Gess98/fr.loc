<?php

namespace PHPFramework;

// Класс Application инициализирует все классы приложения и предоставляет объекты и их методы

class Application
{
    // строка запроса
    protected string $uri;

    // экземпляр класса Request
    public Request $request;

    // экземпляр класса Response
    public Response $response;

    // экземпляр класса Router
    public Router $router;

    // экземпляр класса Application
    public static Application $app;

    public function __construct()
    {
        self::$app = $this;
        $this->uri = $_SERVER['QUERY_STRING'];
        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        // var_dump($this->uri);
    }

    public function run():void
    {
        echo $this->router->dispatch();
    }

}
