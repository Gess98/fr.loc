<?php

namespace PHPFramework;

use Illuminate\Database\Capsule\Manager as Capsule;

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

    // экземпляр класса Cache
    public Cache $cache;

    // экземпляр класса Database
    public Database $db;

    // экземпляр класса Application
    public static Application $app;

    // Свойство для хранения данных
    protected array $container = [];

    public function __construct()
    {
        self::$app = $this;
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View(LAYOUT);
        $this->session = new Session();
        $this->cache = new Cache();
        $this->generateCsrfToken();
        $this->db = new Database();
        Auth::setUser();
    }

    public function run():void
    {
        echo $this->router->dispatch();
    }

    // Генерация Csrf токена
    public function generateCsrfToken(): void
    {
        if (!session()->has('csrf_token')) {
            session()->set('csrf_token', md5(uniqid(mt_rand(), true)));
        }
    }

    // сеттер для $container
    public function set($key, $value): void
    {
        $this->container[$key] = $value;
    }

    // геттер для $container
    public function get($key, $default = null)
    {
        // Если в контейнере есть элемент с заданным ключем, то вернет его, если нет, то значение по дефолту
        return $this->container[$key] ?? $default;
    }

}
