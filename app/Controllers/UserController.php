<?php

namespace App\Controllers;

use App\Models\AuthentificationUser;
use App\Models\User;
use PDOException;
use PHPFramework\Pagination;

class UserController extends BaseController
{
    public function register()
    {
        // db()->query("insert into phones (user_id, phone) values (?,?)", [23, 22799]);
        // dump(1/0);
        // try {
        //     db()->beginTransaction();
        //     
        //     db()->query("insert into users (name, email, password) values (?,?,?)", ['User_23', 'user23@email.com', '123456']);
        //     db()->commit();
        // } catch(PDOException $e) {
        //     db()->rollBack();
        //     dump($e);
        // }
        
        return view('user/register', 
        ['title' => 'Register page',
        ]);
    }

    public function store()
    {
        $model = new User();
        $model->loadData();

        if (request()->isAjax()) {
            if (!$model->validate()) {
                echo json_encode(['status' => 'error', 'data' => $model->listErrors()]);
                die;
            }

            $model->attributes['password'] = password_hash($model->attributes['password'], PASSWORD_DEFAULT);
            if ($id = $model->save()) {
                echo json_encode(['status' => 'success', 'data' => sprintf(__('user_store_success'), $id),
                'redirect' => base_href('/login'),
                ]);
                session()->setFlash('success', 'Thanks for registration. Your ID: ' . $id);
            }else {
                echo json_encode(['status' => 'error', 'data' => 'Error registration']);
            }
            die;
        }

        if(!$model->validate()) {
            session()->setFlash('error', 'Validation errors');
            session()->set('form_errors', $model->getErrors());
            session()->set('form_data', $model->attributes);
        }else{
            $model->attributes['password'] = password_hash($model->attributes['password'], PASSWORD_DEFAULT);
            if ($id = $model->save()) {
                session()->setFlash('success', 'Thanks for registration. Your ID: ' . $id);
            }else {
                session()->setFlash('error', 'Error registration');
            }   
        }
        response()->redirect('/register');
    }

    public function login()
    {
        return view('user/login', [
            'title' => 'Login page',
            // 'styles' => [
            //     base_url("/assets/css/test.css")
            // ],
            // 'header_scripts' => [
            //     base_url("/assets/js/test.js"),
            //     base_url("/assets/js/test2.js")
            // ],
            // 'footer_scripts' => [
            //     base_url("/assets/js/test3.js")
            // ],
        ]);
    }

    // Метод отвечающий за аутентификацию пользователя
    public function authentification()
    {
        // дописать ошибку email-а
        $email = $_POST['email'];
        $password =  $_POST['password'];

        $model = new AuthentificationUser();
        $model->loadData();

        if(!$model->validate()) {
            session()->setFlash('error', 'Validation errors');
            session()->set('form_errors', $model->getErrors());
            session()->set('form_data', $model->attributes);
            response()->redirect('/login');
        } else {
            // dump($email, $password);
            // select * from users where email = 'user1@mail.com';
            $user = db()->query("select * from users where email = ?", [$email])->getOne();
            if (!$user) {
                session()->setFlash('error', 'There is no user with such data');
                response()->redirect('/login');
            }
            // dump(password_verify($password, $user['password']));
            if(password_verify($password, $user['password'])) {
                session()->set('user_id', $user['id']);
                session()->setFlash('success', 'Welcome, ' . $user['name']);
                response()->redirect('/dashboard');
            } else {
                session()->setFlash('error', 'There is no user with such data');
                response()->redirect('/login');
            }
        }

        
    }

    public function index()
    {
        // Запрос данных для кэширования
        if ($page = cache()->get(request()->rawUri)) {
            return $page;
        }

        // дописать метод, который рассчитываает количество строк в таблице по названию таблицы
        $user_cnt = db()->query("select count(*) from users")->getColumn();
        $limit = PAGINATION_SETTINGS['perPage'];
        $pagination = new Pagination($user_cnt);

        $users = db()->query("select * from users limit $limit offset {$pagination->getOffset()}")->get();
        
        // Кэширование страниц пользователей
        // $page = view('user/index', 
        // [
        //     'title' => 'Users',
        //     'users' => $users,
        //     'pagination' => $pagination,
        // ]);

        // cache()->set(request()->rawUri, $page);
        
        // return $page;

        return view('user/index', 
        [
            'title' => 'Users',
            'users' => $users,
            'pagination' => $pagination,
        ]);
    }
}
