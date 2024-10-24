<?php

/** @var \PHPFramework\Application $app */

use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\UserController;

// Константа для регистрации middleware
const MIDDLEWARE = [
    'auth' => \PHPFramework\Middleware\Auth::class,
    'guest' => \PHPFramework\Middleware\Guest::class,
];

$app->router->get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth']);
$app->router->get('/register', [UserController::class, 'register'])->middleware(['guest']);
$app->router->post('/register', [UserController::class, 'store'])->middleware(['guest']);
$app->router->get('/login', [UserController::class, 'login'])->middleware(['guest']);
$app->router->get('/users', [UserController::class, 'index']);
$app->router->get('/posts', [PostController::class, 'index']);

// (?P<something>) запоминание регулярного выражения ,чтобы потом достать его по этому ключу
$app->router->get('/post/(?P<id>[0-9]+)', function (){
    dump(app()->router->route_params);
    return "Post " . get_route_params('id', 'test');
});

$app->router->get('/', [HomeController::class, 'index']);

// dump(app()->router->getRoutes());