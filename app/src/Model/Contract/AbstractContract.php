<?php

namespace App\Model\Contract;

use stdClass;

/**
 * Represents a class AbstractContract
 *
 * @author Valeriy Khomenko
 */
abstract class AbstractContract 
{
    /**
     * Sets data in the instance
     * 
     * @param array $data
     * @return Comment
     */
    public function setData(array $data) : Comment 
    {
        $props = array_keys(get_object_vars($this));
        
        foreach ($props as $prop) {
            
            if (isset($data[$prop])) {
                
                $method = "set" . ucwords($prop);
                $this->$method($data[$prop]);
            }
        }
        
        return $this;
    }
    
    /**
     * Converts this instance to an instance of a stdClass
     * 
     * @return stdClass
     */
    public function toStdObject() : stdClass
    {
        $res = new stdClass();
        $props = array_keys(get_object_vars($this));
        
        foreach ($props as $prop) {
            
            $method = "get" . ucwords($prop);
            $res->$prop = $this->$method();
        }
        
        return $res;        
    }        
}
