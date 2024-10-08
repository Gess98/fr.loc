<?php

namespace PHPFramework;

class View
{
    // шаблон
    public string $layout;

    // вид
    public string $content = '';

    public function __construct($layout)
    {
        $this->layout = $layout;
    }

    // метод для подключения вида и шаблона
    public function render($view, $data = [], $layout = ''): string
    {

        extract($data);

        // подключение вида
        $view_file = VIEWS . "/{$view}.php";
        if(is_file($view_file)) {
            ob_start(); // Перенос вида в буфер, чтобы его можно было открыть внутри шаблона
            require $view_file;
            $content = ob_get_clean();
        } else {
            abort("Not found view {$view_file}", 500);
        }

        if (false === $layout) {
            return $this->content;
        }

        // подключение шаблона
        $layout_file_name = $layout ?: $this->layout;
        $layout_file = VIEWS . "/layouts/{$layout_file_name}.php";
        if(is_file($layout_file)) {
            ob_start();
            require_once $layout_file;
            return ob_get_clean();
        } else {
            abort("Not found layout {$layout_file}", 500);
        }

        return '';
    }

    public function renderPartial($view, $data = []): string
    {
        
        extract($data);
        $view_file = VIEWS . "/{$view}.php";

        if(is_file($view_file)) {
            ob_start(); // Перенос вида в буфер, чтобы его можно было открыть внутри шаблона
            require $view_file;
            return ob_get_clean();
        } else {
            return "File {$view_file} not found";
        }
    }

}
