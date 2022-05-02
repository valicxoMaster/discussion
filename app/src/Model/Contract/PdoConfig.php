<?php

namespace App\Model\Contract;

/**
 * Presents an instance of PdoConfig
 *
 * @author Valeriy Khomenko
 */
class PdoConfig extends AbstractContract
{
    /**
     * 
     * @var string
     */
    protected $dsn = '';
    
    /**
     * 
     * @var string
     */
    protected $user = '';
    
    /**
     * 
     * @var string
     */
    protected $password = '';    
    
    /**
     * 
     * @return PdoConfig
     */
    public static function createFromEnvironment() : PdoConfig 
    {
        //$dsn = "mysql:host=cmts-demo-mysql;port=3306;dbname=comdata"; 
        $dsn = !empty($_ENV["MYSQL_DSN"])? $_ENV["MYSQL_DSN"] : "";
        $user = !empty($_ENV["MYSQL_USER"])? $_ENV["MYSQL_USER"] : "";
        $pass = !empty($_ENV["MYSQL_PASS"])? $_ENV["MYSQL_PASS"] : "";
        
        $res = new PdoConfig();
        $res->setDsn($dsn);
        $res->setUser($user);
        $res->setPassword($pass);
        return $res;
    }

    /**
     * 
     * @param string $dsn
     * @return PdoConfig
     */
    public function setDsn(string $dsn) : PdoConfig
    {
        $this->dsn = $dsn;
        return $this;        
    }
    
    /**
     * 
     * @return string
     */
    public function getDsn() : string
    {
        return $this->dsn;
    }

    /**
     * 
     * @param string $user
     * @return PdoConfig
     */
    public function setUser(string $user) : PdoConfig
    {
        $this->user = $user;
        return $this;        
    }
    
    /**
     * 
     * @return string
     */
    public function getUser() : string
    {
        return $this->user;
    }

    /**
     * 
     * @param string $password
     * @return PdoConfig
     */
    public function setPassword(string $password) : PdoConfig
    {
        $this->password = $password;
        return $this;        
    }
    
    /**
     * 
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }
}
