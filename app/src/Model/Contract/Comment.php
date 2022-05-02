<?php

namespace App\Model\Contract;

use stdClass;

/**
 * Class presents an instance of a comment
 *
 * @author Valeriy Khomenko
 */
class Comment 
{
    /**
     * @var string|null
     */
    protected $id = null;
            
    /**
     * 
     * @var string
     */
    protected $email = '';

    /**
     * 
     * @var string
     */
    protected $userName = '';

    /**
     * 
     * @var string
     */
    protected $content = '';
    
    /**
     * Sets data in the instance
     * 
     * @param array $data
     * @return Comment
     */
    public function setData(array $data) : Comment 
    {
        $props = array_keys(get_class_vars(self::class));

        foreach ($props as $prop) {
            
            $method = "set" . ucwords($prop);
            $this->$method($data[$prop]);
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
        $props = array_keys(get_class_vars(self::class));
        
        foreach ($props as $prop) {
            
            $method = "get" . ucwords($prop);
            $res->$prop = $this->$method();
        }
        
        return $res;        
    }    

    /**
     * 
     * @param string|null $id
     * @return Comment
     */
    public function setId(?string $id) : Comment
    {
        $this->id = $id;
        return $this;        
    }
    
    /**
     * 
     * @return string|null
     */
    public function getId() : ?string
    {
        return $this->id;
    }

    /**
     * 
     * @param string $email
     * @return Comment
     */
    public function setEmail(string $email) : Comment
    {
        $this->email = $email;
        return $this;        
    }
    
    /**
     * 
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }
    
    /**
     * 
     * @param string $userName
     * @return Comment
     */
    public function setUserName(string $userName) : Comment
    {
        $this->userName = $userName;
        return $this;        
    }
    
    /**
     * 
     * @return string
     */
    public function getUserName() : string
    {
        return $this->userName;
    }

    /**
     * 
     * @param string $content
     * @return Comment
     */
    public function setContent(string $content) : Comment
    {
        $this->content = $content;
        return $this;        
    }
    
    /**
     * 
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }    
}
