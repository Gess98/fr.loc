<?php

namespace PHPFramework;

// Класс маршрутизатор

class Router
{

     // экземпляр класса Request
     protected Request $request;

     // экземпляр класса Response
     protected Response $response;

    // Массив маршрутов
    protected array $routes = [];

    // Массив параметров для маршрутов
    protected array $route_params = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    // Функция для добавления маршурута
    public function add($path, $callback, $method):self
    {
        $path = trim($path, '/');
        if(is_array($method)) {
            $method = array_map('strtoupper', $method);
        } else {
            $method = [strtoupper($method)];
        }

        $this->routes[] = [
            'path' => "/$path",
            'callback' => $callback,
            'middleware' => null,
            'method' => $method,
            'needToken' => true
        ];

        return $this;
    }
    // Функция для добавления маршурута с методом get
    public function get($path, $callback):self
    {
        return $this->add($path, $callback, 'GET');
    }

    // Функция для добавления маршурута с методом post
    public function post($path, $callback):self
    {
        return $this->add($path, $callback, 'POST');
    }

    // Получение массива с маршрутами
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function dispatch():mixed
    {
        $path = $this->request->getPath();
        $route = $this->matchRoute($path);
        if (false === $route) {
            $this->response->setResponseCode(404);
            echo "404 - Page not found";
            die();
        }

        if(is_array($route['callback'])) {
            $route['callback'][0] = new $route['callback'][0];
        }
        
        return call_user_func($route['callback']);

    }

    protected function matchRoute($path):mixed
    {
        foreach($this->routes as $route) {
            if(
                preg_match("#^{$route['path']}$#", "/{$path}", $matches)
                && in_array($this->request->getMethod(), $route['method'])
            ) {
                foreach ($matches as $k => $v)  {
                    if(is_string($k)) {
                        $this->route_params[$k] = $v;
                    }
                }  
                return $route;      
            }
        }
        return false;

    }
}
