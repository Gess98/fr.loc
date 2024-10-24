<?php

// Возвращаеты экземпляр класса Application
function app(): PHPFramework\Application 
{
    return \PHPFramework\Application::$app;
}

// Возвращает экземпляр класса Request
function request(): PHPFramework\Request
{
    return app()->request;
}

// Возвращает экземпляр класса Session
function session(): PHPFramework\Session
{
    return app()->session;
}

// Возвращает экземпляр класса Cache
function cache(): PHPFramework\Cache
{
    return app()->cache;
}

// Посмотреть все параметры
function get_route_params($key, $default = ''): string
{
    return app()->router->route_params[$key] ?? $default;
}

// Поиск данных в массиве (двумерном)
function array_value_search($arr, $index, $value): int|null|string
{
    foreach($arr as $k => $v) {
        if($v[$index] == $value) {
            return $k;
        }
    }
    return null;
}

// Возвращает экземпляр класса Db
function db(): PHPFramework\Database
{
    return app()->db;
}

// Возвращает экземпляр класса Response
function response(): PHPFramework\Response
{
    return app()->response;
}

// Возвращает экземпляр класса View или применяет метод render класса View
function view($view = '', $data = [], $layout = ''): string |\PHPFramework\View
{
    if($view) {
        return app()->view->render($view, $data, $layout);
    }
    return app()->view;
}

// Возвращает экземпляр класса Request
function abort($error = '', $code = '404') 
{
    response()->setResponseCode($code);
    echo view("errors/{$code}", ['error' => $error], false);
    die;
}

// Возвращает путь к файлу
function base_url($path = ''):string
{
    return PATH . $path;
}

// 
function base_href($path = ''): string
{
    if (app()->get('lang')['base'] != 1) {
        return PATH . '/' . app()->get('lang')['code'] . $path;
    }
    return PATH . $path;
}

// Возвращает url адресс без языка
function uri_without_lang()
{
    $request_uri = request()->uri;
    // Получение 2 параметров из uri путем разбиения по /
    $request_uri = explode('/', $request_uri, 2); // en/login/еще-что-то разобьет на ['0' => 'en', '1' => 'login/еще что-то']
    if (array_key_exists($request_uri[0], LANGS)) {
        unset($request_uri[0]);
    }
    $request_uri = implode('/', $request_uri);
    return $request_uri ? '/'. $request_uri : '';
}

// Присваивание ошибки по ключу
function get_alerts(): void
{
    if (!empty($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $k => $v) {
            echo view()->renderPartial("incs/alert_{$k}", ["flash_{$k}" => session()->getFlash($k)]);
        }
    }
}

// Получает ошибки и записывает в переменную
function get_errors($fieldname): string
{
    $output = '';
    $errors = session()->get('form_errors');
    if (isset($errors[$fieldname])) {
        $output .= '<div class="invalid-feedback d-block"><ul class="list-unstyled">';
            foreach($errors[$fieldname] as $error) {
                $output .= "<li>$error</li>";
            }
        $output .= '</ul></div>';
    }
    return $output;
}

function get_validation_class($fieldname): string
{
    $errors = session()->get('form_errors');
    if (empty($errors)) {
        return '';
    }
    return isset($errors[$fieldname]) ? 'is-invalid' : 'is-valid';
}

// Функция для автозаполнения данных формы после неудачного ввода
function old($fieldname): string 
{
    return isset(session()->get('form_data')[$fieldname]) ? h(session()->get('form_data')[$fieldname]) : '';
}

// Обертка над htmlspecialchars()
function h($str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

// Добавление поля в форму для проверки csrf token
function get_csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . session()->get('csrf_token') . '">';
}

// Meta csrf token
function get_csrf_meta(): string
{
    return '<meta name="csrf-token" content="' . session()->get('csrf_token') . '">';
}

// Проверка залогирован пользователь или нет
function check_auth():bool
{
    return false;
}