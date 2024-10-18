<?php
// Константа, которая возвращает путь у к корню проекта
define("ROOT", dirname(__DIR__));
// Константа для отладки. 0 - режим отладки выключен. 1 - режим отладки включен
const DEBUG = 1;
// Константа, которая возвращает путь к папке public
const WWW = ROOT . "/public";
// Константа, которая возвращает путь к папке config
const CONFIG = ROOT . "/config";
// Константа, которая возвращает путь к папке helpers
const HELPERS = ROOT . "/helpers";
// Константа, которая возвращает путь к папке App
const APP = ROOT . "/app";
// Константа, которая возвращает путь к папке core
const CORE = ROOT . "/core";
// Константа, которая возвращает путь к папке Views
const VIEWS = APP . "/Views";
// Константа, которая возвращает путь к файлу с ошибками
const ERROR_LOGS = ROOT . "/tmp/error.log";
// Константа, которая возвращает шаблон
const LAYOUT = 'default';
// Константа, которая возвращает URL сайта
const PATH = 'https://fr.loc';
// Константа с настройками базы данных
const DB_SETTINGS = [
    'driver' => 'mysql',
    'host' => 'MariaDB-11.2',
    'database' => 'fr_loc',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'port' => 3306,
    'prefix' => '',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
];

const PAGINATION_SETTINGS = [
    'perPage' => 3,
    'midSize' => 2,
    'maxPages' => 7,
    'tpl' => 'pagination/base'
];