<?php

namespace PHPFramework;

// Класс для работы с сессией
class Session 
{

    // В конструкторе будет стартовать сессия
    public function __construct()
    {
        session_start();
    }

    // Запись каких-либо элементов в массив $_SESSION
    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    // Получение каких-либо элементов из массива $_SESSION
    public function get($key, $default = null)
    {
        // Равносильно isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
        // Если $_SESSION[$key]) существует и отлично от null, то вернет его, иначе вернет $default
        return $_SESSION[$key] ?? $default;
    }

    // Проверка элемента на существование по ключу из массива $_SESSION
    public function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    // Удаление элемента по ключу из массива $_SESSION
    public function remove($key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    // Запись каких-либо элементов для флеш-сообщений в массив $_SESSION
    public function setFlash($key, $value): void
    {
        $_SESSION['flash'][$key] = $value;
    }

    // Получение каких-либо элементов из массива $_SESSION['flash'] и последующее его удаление
    public function getFlash($key, $default = null)
    {
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
        }

        return $value ?? $default;
    }

}