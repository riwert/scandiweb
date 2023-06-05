<?php

namespace RAPI\config;

class Response
{
    public static function handle($json, $code)
    {
        header('Content-Type: application/json');
        http_response_code($code || 500);
        echo json_encode($json);
        exit();
    }
}
