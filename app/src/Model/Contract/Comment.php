<?php

namespace App\Model\Contract;

/**
 * Class presents an instance of a comment
 *
 * @author Valeriy Khomenko
 */
class Comment extends AbstractContract
{
    /**
     * @var string|null
     */
    protected $id = null;
    
    /**
     * 
     * @var int
     */
    protected $articleId = 0;

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
     * @var int
     */
    protected $userId = '';
    
    /**
     * 
     * @var string
     */
    protected $updated;

    /**
     * 
     * @var string
     */
    protected $content = '';        

    /**
     * 
     * @param string $id
     * @return Comment
     */
    public function setUpdated(string $updated) : Comment
    {
        $this->updated = $updated;
        return $this;        
    }
    
    /**
     * 
     * @return string
     */
    public function getUpdated() : string
    {
        return $this->updated;
    }
    
    /**
     * 
     * @param int $id
     * @return Comment
     */
    public function setUserId(int $id) : Comment
    {
        $this->userId = $id;
        return $this;        
    }
    
    /**
     * 
     * @return int
     */
    public function getUserId() : int
    {
        return $this->userId;
    }
    
    /**
     * 
     * @param int $id
     * @return Comment
     */
    public function setArticleId(int $id) : Comment
    {
        $this->articleId = $id;
        return $this;        
    }
    
    /**
     * 
     * @return int
     */
    public function getArticleId() : int
    {
        return $this->articleId;
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
