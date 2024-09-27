<?php

namespace App\Controllers;

class HomeController
{
    
    public function index() 
    {
        return view('test', ['name' => 'John22', 'age' => 36]);
        // app()->view->render('test', ['name' => 'John', 'age' => 36]);
        return "Home page";
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
