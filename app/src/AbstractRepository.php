<?php

namespace App;

use \PDO;
use App\Model\Contract\PdoConfig;

/**
 * Represents the class AbstractRepository
 *
 * @author Valeriy Khomenko
 */
abstract class AbstractRepository 
{
    /**
     * 
     * @var PDO
     */
    protected $pdo;

    /**
     * 
     * @param PdoConfig $cfg
     */
    public function __construct(PdoConfig $cfg) 
    {        
        $this->pdo = new PDO(
            $cfg->getDsn(), 
            $cfg->getUser(), 
            $cfg->getPassword()
        );
    }
}
