<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    
    public function index() 
    {
        return view('home', ['title' => 'Home page']);
    }

    public function test() 
    {
        app()->view->render('test', ['name' => 'John']);
    }

    public function contact() 
    {
        return "Contact page";
    }
}
