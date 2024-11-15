<?php

/** @var \PHPFramework\Application $app */

use App\Controllers\ContactController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\UserController;

// Константа для регистрации middleware
const MIDDLEWARE = [
    'auth' => \PHPFramework\Middleware\Auth::class,
    'guest' => \PHPFramework\Middleware\Guest::class,
];
// (?P<something>) запоминание регулярного выражения ,чтобы потом достать его по этому ключу
$app->router->get('/admin/post/(?P<slug>[a-z0-9-_]+)', [PostController::class, 'delete']);
$app->router->get('/admin/posts', [PostController::class, 'admin_index']);
$app->router->get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth']);
$app->router->get('/register', [UserController::class, 'register'])->middleware(['guest']);
$app->router->post('/register', [UserController::class, 'store'])->middleware(['guest']);
$app->router->get('/login', [UserController::class, 'login'])->middleware(['guest']);
$app->router->post('/login', [UserController::class, 'auth']);
$app->router->get('/users', [UserController::class, 'index']);
$app->router->get('/posts', [PostController::class, 'index']);
$app->router->get('/logout', [UserController::class, 'logout'])->middleware(['auth']);
$app->router->get('/admin/new-post', [PostController::class, 'create']);

// (?P<something>) запоминание регулярного выражения ,чтобы потом достать его по этому ключу
$app->router->get('/post/(?P<slug>[a-z0-9-_]+)', [PostController::class, 'post']);

$app->router->get('/contact', [ContactController::class, 'index']);
$app->router->get('/', [HomeController::class, 'index']);

// dump(app()->router->getRoutes());