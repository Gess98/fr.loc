<?php

namespace PHPFramework;

//  Ответ

class Response
{

    // Устанавливает код ответа
    public function setResponseCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect()
    {

    }
}
