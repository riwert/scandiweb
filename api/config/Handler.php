<?php

namespace SWAPI\config;

use SWAPI\config\Response;
use Throwable;

class Handler
{
    public static function handleException(Throwable $exception): string
    {
        // Create an array with the exception details
        $error = [
          'type' => 'exception',
          'code' => $exception->getCode(),
          'error' => $exception->getMessage(),
          'file' => $exception->getFile(),
          'line' => $exception->getLine()
      ];
      // Return the JSON response with appropriate HTTP status code
      return Response::handle($error, 500);
    }

    public static function handleError($errno, $errstr, $errfile, $errline): string
    {
        // Create an array with the error details
        $error = [
          'type' => 'error',
          'code' => $errno,
          'error' => $errstr,
          'file' => $errfile,
          'line' => $errline
      ];
      // Return the JSON response with appropriate HTTP status code
      return Response::handle($error, 500);
    }
}
