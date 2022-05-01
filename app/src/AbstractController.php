<?php

namespace App;

use App\Exception\RequestException;

/**
 * Abstract controller
 *
 * @author Valeriy Khomenko
 */
abstract class AbstractController 
{
    protected static function checkMethod(string $method)
    {        
        if ($_SERVER["REQUEST_METHOD"] !== strtoupper($method)) {
            
            throw new RequestException("The request has wrong http method");
        }
    }
}
