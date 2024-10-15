<?php

namespace App\Controllers;

use App\Models\User;
use Illuminate\Database\Capsule\Manager as Capsule;
use PDOException;

class UserController extends BaseController
{
    public function register()
    {

        // $users = Capsule::table('users')->select('id', 'name')->get();

        // Capsule::enableQueryLog();
        // $user = User::query()->with('phones')->find(1);
        // dump($user);
        // dump($user->phones);

        // dump(Capsule::getQueryLog());

        // $users = db()->query('select * from users where id > ?', [5])->get();
        // dump($users);

        // $users = db()->query('select * from users')->getAssoc();
        // dump($users);

        // $user = db()->query('select * from users where id = ?', [3])->getOne();
        // dump($user);
        
        // (db()->query('select count(*) from users')->getColumn());

        // $users = db()->findAll('users');
        // dump($users);

        // $user = db()->findOne('users', 'sasha@mail.com', 'email');
        // dump($user);

        // $user = db()->findOrFail('users', "sasha@mail.com", 'email');
        // dump($user);

        // db()->query("insert into phones (user_id, phone) values (?, ?)", ['3', '355555']);
        // dump(db()->getInsertId());

        // db()->query("delete from phones where id > ?", [5]);
        // dump(db()->rowCount());

        try {
            db()->beginTransaction();
            db()->query("insert into phones (user_id, phone) values (?,?)", [23, 22799]);
            db()->query("insert into users (name, email, password) values (?,?,?)", ['User_23', 'user23@email.com', '123456']);
            db()->commit();
        } catch(PDOException $e) {
            db()->rollBack();
            dump($e);
        }
        
        return view('user/register', 
        ['title' => 'Register page',
        ]);
    }

    public function store()
    {
        $model = new User();
        $model->loadData();
        if(!$model->validate()) {
            session()->setFlash('error', 'Validation errors');
            session()->set('form_errors', $model->getErrors());
            session()->set('form_data', $model->attributes);
        }else{
            // dump(User::query()->create([
            //     'name' => $model->attributes['name'],
            //     'email' => $model->attributes['email'],
            //     'password' => $model->attributes['password'],
            // ]));
            // unset($model->attributes['confirmPassword']);
            if ($model->save()) {
                session()->setFlash('success', 'Thanks for registration');
            }else {
                session()->setFlash('error', 'Error registration');
            }   
            // dd($model->attributes);
            // session()->setFlash('success', 'Successfully validation');
        }
        response()->redirect('/register');
        // dump($model->attributes);
        // dump($model->validate());
        // dump($model->getErrors());
        // dd($_POST);
    }

    public function login()
    {
        return view('user/login', ['title' => 'Login page']);
    }
}
