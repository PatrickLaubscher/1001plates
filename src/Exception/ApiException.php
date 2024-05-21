<?php namespace App\Exception;

use Exception;

class ApiException extends Exception
{
    private $statuscode;

    public function __construct(string $message, int $code = 0, \Throwable $previous = null)
    {
        

    }



}