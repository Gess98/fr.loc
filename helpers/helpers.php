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
    return PHPFramework\Auth::isAuth();
}

function get_user()
{
    return \PHPFramework\Auth::user();
}

function logout()
{
    \PHPFramework\Auth::logout();
}

// Выводит из массива lang_data по ключу key
function _e($key): void
{
    echo PHPFramework\Language::get($key);
}

// Возвращает из массива lang_data по ключу key
function __($key): string
{
    return PHPFramework\Language::get($key);
}

// Функция для отправки сообщений
function send_mail(array $to, string $subject, string $tpl, array $data = [], array $attacments = []):bool
{
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->SMTPDebug = MAIL_SETTINGS['debug'];
        $mail->isSMTP();
        $mail->Host = MAIL_SETTINGS['host'];
        $mail->SMTPAuth = MAIL_SETTINGS['auth'];
        $mail->Username = MAIL_SETTINGS['username'];
        $mail->Password = MAIL_SETTINGS['password'];
        $mail->SMTPSecure = MAIL_SETTINGS['secure'];
        $mail->Port = MAIL_SETTINGS['port'];

        $mail->setFrom(MAIL_SETTINGS['from_email'], MAIL_SETTINGS['from_name']);
        // Добавление адресатов
        foreach ($to as $email) {
            $mail->addAddress($email);
        }
        // Добавление вложений в письма
        if ($attacments) {
            foreach ($attacments as $attacment) {
                $mail->addAttachment($attacment);
            }
        }

        $mail->isHTML(MAIL_SETTINGS['is_html']);
        $mail->CharSet = MAIL_SETTINGS['charset'];
        $mail->Subject = $subject;
        // Подключение шаблона
        $mail->Body = view($tpl, $data, false);

        return $mail->send();
    } catch (Exception $e) {
        error_log("[" . date('Y-m-d H:i:s'). "] Error: {$e->getMessage()}" . PHP_EOL . "File: {$e->getFile()}" . PHP_EOL . 
        "Line: {$e->getLine()}" . PHP_EOL . '--------------------' . PHP_EOL, 3, ERROR_LOGS);
        return false;
    }
}