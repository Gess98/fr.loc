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

