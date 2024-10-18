<?php

namespace PHPFramework;

// Класс запроса пользователя

class Request
{
    public $uri;

    public string $rawUri;

    public function __construct($uri)
    {
        // Uri без декодирования и с концевыми слешами
        $this->rawUri = $uri;
        // Декодирование url адреса ('+' заменяется на пробел и т.д.) и обрезание концевого слеша
        $this->uri = trim(urldecode($uri), '/');
    }

    // Возвращение метода который был использован для запроса страницы в верхнем регистре
    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    // Проверка является ли запрошенный метод GET
    public function isGet(): bool
    {
        return $this->getMethod() == 'GET';
    }

    // Проверка является ли запрошенный метод POST
    public function isPost(): bool
    {
        return $this->getMethod() == 'POST';
    }

    // Проверка является ли запрошенный метод асинхронным
    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    // Получение чего-то из массива get
    public function get($name, $default = null): ?string
    {
        return $_GET[$name] ?? $default;
    }

    // Получение чего-то из массива post
    public function post($name, $default = null): ?string
    {
        return $_POST[$name] ?? $default;
    }

    // Получение пути   
    public function getPath(): string
    {
        return $this->removeQueryString();
    }

    protected function removeQueryString(): string
    {
        if($this->uri) {
            $params = explode('?', $this->uri);
            return trim($params[0], "/");
        }
        return '';
    }

    // Получение данных из массива POST или GET
    public function getData(): array
    {
        $data = [];
        $request_data = $this->isPost() ? $_POST : $_GET;
        foreach ($request_data as $k => $v) {
            if(is_string($v)) {
                $v = trim($v);
            }
            $data[$k] = $v;
        }
        return $data;
    }
}
