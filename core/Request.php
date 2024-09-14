<?php

namespace PHPFramework;

// Класс запроса пользователя

class Request
{
    public $uri;

    public function __construct($uri)
    {
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
    public function get($name, $defaul = null): ?string
    {
        return $_GET[$name] ?? $defaul;
    }

    // Получение чего-то из массива post
    public function post($name, $defaul = null): ?string
    {
        return $_POST[$name] ?? $defaul;
    }
}
