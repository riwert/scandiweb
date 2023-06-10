<?php

namespace RAPI\config;

class Response
{
    public static function handle($json, $code = 500)
    {
        // Set CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

        // Handle preflight OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        if (!is_numeric($code)) {
            $code = 500;
        }

        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($json);
        exit();
    }
}
