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

    // экземпляр класса View
    public View $view;

    // экземпляр класса Session
    public Session $session;

    // экземпляр класса Application
    public static Application $app;

    public function __construct()
    {
        self::$app = $this;
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View(LAYOUT);
        $this->session = new Session();
    }

    public function run():void
    {
        echo $this->router->dispatch();
    }

}
