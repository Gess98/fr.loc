<?php

namespace App\Controllers;

class ContactController extends BaseController
{
    
    public function index() 
    {
        dump(send_mail(
            ['zhorochka.sokolov@yandex.ru'], 
            'Test 2',
            'email/test',
            ['name' => 'Nick', 'age' => 28]));
        return view('contact/index', ['title' => 'Contact page']);
    }

}
