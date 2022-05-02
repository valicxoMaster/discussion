<?php

namespace App\Model\Http;

use stdClass;

/**
 * Presents an instance of HttpResponse
 *
 * @author Valeriy Khomenko
 */
class HttpResponse 
{
    /**
     * 
     * @var int
     */
    protected $code = 200;
    
    /**
     * 
     * @var string
     */
    protected $contentType = "application/json";

    /**
     * 
     * @var mixed
     */
    protected $mixedObjectOrArray;
    
    /**
     * 
     */
    public function __construct() 
    {        
        $this->mixedObjectOrArray = new \stdClass();
    }
    
    /**
     * 
     * @return HttpResponse
     */
    public static function create() : HttpResponse 
    {
        $res = new HttpResponse();
        return $res;
    }

    /**
     * 
     * @param int $code
     * @return HttpResponse
     */
    public function setCode(int $code) : HttpResponse 
    {
        $this->code = $code;
        return $this; 
    }
    
    /**
     * 
     * @param string $contentType
     * @return HttpResponse
     */
    public function setContentType(string $contentType) : HttpResponse 
    {
        $this->contentType = $contentType;
        return $this; 
    }
    
    /**
     * 
     * @param mixed $mixedObjectOrArray
     * @return HttpResponse
     */
    public function setData($mixedObjectOrArray) : HttpResponse 
    {        
        $this->mixedObjectOrArray = $mixedObjectOrArray;
        
        if (is_string($this->mixedObjectOrArray)) {
            
            $this->mixedObjectOrArray = new stdClass();
            $this->mixedObjectOrArray->message = $mixedObjectOrArray;
        }
        
        return $this; 
    }   
    
    /**
     * 
     * @return void
     */
    public function send() : void
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Content-Type: " . $this->contentType . "; charset=utf-8");
        http_response_code($this->code);
        die(json_encode($this->mixedObjectOrArray));
    }
}
