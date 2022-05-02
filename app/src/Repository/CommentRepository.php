<?php

namespace App\Repository;

use App\AbstractRepository;
use App\Model\Contract\Comment;

/**
 * Presents an instance of UserRepository
 *
 * @author Valeriy Khomenko
 */
class CommentRepository extends AbstractRepository
{
    /**
     * 
     * @param Comment $comment
     * @return int
     */
    public function insert(Comment $comment) : int 
    {
        try {
            
            $sql = "INSERT INTO `comments` ";
            $sql.= "(article_id, user_id, enabled, updated, content) ";
            $sql.= "VALUES(:articleId, :userId, :enabled, :updated, :content)";        
            $sth = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();

            $sth->execute([
                ":articleId" => $comment->getArticleId(),
                ":userId" => $comment->getUserId(),
                ":enabled" => 1,
                ":updated" => $comment->getUpdated(),
                ":content" => $comment->getContent()            
            ]);    
            
            $id = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return intval($id);
        } catch (\PDOException $ex) {
            
            if ($this->pdo->inTransaction()) {
                
                $this->pdo->rollback();
            }
            
            return null; 
        }

        return true;
    }
}
