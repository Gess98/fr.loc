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
    public array $route_params = [];

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
            'middleware' => [],
            'method' => $method,
            'needCsrfToken' => true
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
            abort('Test 404 error');
        }

        if(is_array($route['callback'])) {
            $route['callback'][0] = new $route['callback'][0];
        }
        
        return call_user_func($route['callback']);

    }

    protected function matchRoute($path):mixed
    {
        foreach($this->routes as $route) {
            if(MULTILANGS) {
                // Паттерн для строки запроса c возможной группой запомненного lang
                $pattern = "#^/?(?P<lang>[a-z]+)?{$route['path']}?$#";
            }else {
                $pattern = "#^{$route['path']}$#";
            }
            if(
                preg_match($pattern, "/{$path}", $matches)
                && in_array($this->request->getMethod(), $route['method'])
            ) {

                foreach ($matches as $k => $v)  {
                    if(is_string($k)) {
                        $this->route_params[$k] = $v;
                    }
                }

                // Если язык есть, но его нет в массиве допустимых, то вернуть 404 ошибку
                // Если язык есть и это базовый язык, то вернуть 404 ошибку
                $lang = trim(get_route_params('lang'), '/');
                
                $base_lang = array_value_search(LANGS, 'base', 1);
                
                if (($lang && !array_key_exists($lang, LANGS)) || $lang == $base_lang) {
                    abort();
                } 

                $lang = $lang ?: $base_lang;
                app()->set('lang', LANGS[$lang]);

                Language::load($route['callback']);

                if (request()->isPost()) {
                    if ($route['needCsrfToken'] && !$this->checkCsrfToken()) {
                        if (request()->isAjax()) {
                            echo json_encode([
                                'status' => 'error',
                                'data' => 'Security error'
                            ]);
                            die;
                        } else {
                            abort('Page expired', '419');
                        }
                    }
                }

                // проверка на наличие middleware
                if($route['middleware']) {
                    foreach($route['middleware'] as $item) {
                        $middleware = MIDDLEWARE[$item] ?? false;
                        if($middleware) {
                            (new $middleware)->handle();
                        }
                    }
                }  
                
                return $route;      
            }
        }
        return false;

    }

    // установка 'needCsrfToken' в false
    public function withoutCsrfToken(): self
    {
        $this->routes[array_key_last($this->routes)]['needCsrfToken'] = false;
        return $this;
    }


    // Проверка наличия и возвращение Csrf токена
    public function checkCsrfToken(): bool
    {
        return request()->post('csrf_token') && (request()->post('csrf_token') == session()->get('csrf_token'));
    }

    // метод Middleware
    public function middleware(array $middleware): self
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;
        return $this;
    }
}
