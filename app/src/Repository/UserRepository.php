<?php

namespace App\Repository;

use App\AbstractRepository;
use \PDO;
use \PDOException;
/**
 * Presents an instance of UserRepository
 *
 * @author Valeriy Khomenko
 */
class UserRepository extends AbstractRepository
{
    /**
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email) : ?array 
    {
        try {
            
            $sql = "SELECT * FROM `users` WHERE email = :email LIMIT 1";        
            $sth = $this->pdo->prepare($sql);
            $sth->bindParam(':email', $email);                    
            $sth->execute();        

            $rows = $sth->fetch(PDO::FETCH_ASSOC);
            return empty($rows)? null : $rows;
        } catch (PDOException $ex) {
            
            die($ex->getMessage());
            return null;
        }
    }            

    /**
     * 
     * @param string $email
     * @param string $userName
     * @return int|null
     */
    public function insert(string $email, string $userName): ?int
    {
        try {
            
            $sql = "INSERT INTO `users` (email, user_name) VALUES(:email, :user)";        
            $sth = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();
            
            $sth->execute([
                ":email" => $email,
                ":user" => $userName            
            ]);        
            
            $id = $this->pdo->lastInsertId();            
            $this->pdo->commit();            
            return intval($id);
        } catch (PDOException $ex) {
            
            if ($this->pdo->inTransaction()) {
                
                $this->pdo->rollback();
            }            
            
            return null; 
        }
    }
}
