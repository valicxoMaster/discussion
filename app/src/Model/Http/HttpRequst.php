<?php

namespace App\Model\Http;

use App\Exception\RequestException;


/**
 * Description of HttpRequst
 *
 * @author Valeriy Khomenko
 */
class HttpRequst 
{
    /**
     * 
     * @var array
     */
    protected $route;
    
    /**
     * 
     * @var string
     */
    protected $body;

    /**
     * 
     */
    public function __construct() 
    {
        $this->body = file_get_contents('php://input');
    }

        /**
     * 
     * @param array $route
     */
    public function setRoute(array $route)
    {
        $this->route =  $route;
    }
    
    /**
     * 
     * @return array
     */
    public function getRoute() : array
    {
        return $this->route;
    }    
    
    /**
     * 
     * @return string
     */
    public function getRoutePath() : string
    {
        return $this->route["route"]["controller"]                
                .":"
                .$this->route["route"]["action"];
    }

    /**
     * Checks if the criteria mathes a http params
     * 
     * @param string $method
     * @param string $contentType
     * @return void
     * @throws RequestException
     */
    public function check(string $method, string $contentType = "application/json") : void
    {        
        if ($_SERVER["REQUEST_METHOD"] !== strtoupper($method)) {
            
            throw new RequestException(
                "The request has wrong http method in the route ["
                    .$this->getRoutePath()
                    ."]"
            );
        }
        
        if ($_SERVER["CONTENT_TYPE"] !== $contentType) {
            
            throw new RequestException(
                "The request has wrong http content type ["
                    . $contentType
                    . "] in the route ["
                    .$this->getRoutePath()
                    ."]"
            );
        }
    }
    
    /**
     * 
     * @return string
     */
    public function getBodyContent() : string 
    {        
        return $this->body;
    }    
    
    /**
     * 
     * @return string
     */
    public function getParam() : string 
    {
        return empty($this->getRoute()["route"]["param"])? "" 
        : $this->getRoute()["route"]["param"];
    }
}
