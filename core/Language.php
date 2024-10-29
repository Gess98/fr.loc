<?php

namespace PHPFramework;

class Language
{
    // Данные для языка
    public static array $lang_data = [];
    // Данные для шаблона
    protected static array $lang_layout = [];
    // Данные для вида
    protected static array $lang_view = [];

    public static function load($route)
    {
        // Получение кода языка
        $code = app()->get('lang')['code'];
        // Путь к файлу шаблона с переведенными фразами
        $lang_layout = APP . "/Languages/{$code}.php";
        $lang_view = '';

        if(is_array($route)) {
            // Разбиение App\Controllers\PostController на отдельные состовляющие
            $controller_segments = explode('\\', $route[0]);
            // Получение последнего элемента массива
            $controller_name = array_pop($controller_segments);
            // Получение папки с переводами
            $lang_folder = strtolower(str_replace('Controller', '', $controller_name));
            // Получение файла с переводами
            $lang_file = $route[1];
            $lang_view = APP . "/Languages/$code/$lang_folder/$lang_file.php";
        }

        if(file_exists($lang_layout)) {
            self::$lang_layout = require_once $lang_layout;
        }

        if($lang_view && file_exists($lang_view)) {
            self::$lang_view = require_once $lang_view;
        }

        self::$lang_data = array_merge(self::$lang_layout, self::$lang_view);
    }

    public static function get($key)
    {
        return self::$lang_data[$key] ?? $key;
    }
}