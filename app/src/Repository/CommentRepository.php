<?php

namespace App\Repository;

use App\AbstractRepository;
use App\Model\Contract\Comment;
use PDO;

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
    
    /**
     * 
     * @param int $articleId
     * @return array
     */
    public function list(int $articleId) : array 
    {
        try {
            
            $cmtCols = [
                "cmt.id",
                "cmt.article_id as articleId",
                "cmt.user_id as userId",
                "cmt.enabled",
                "cmt.updated",
                "cmt.content"                
            ];
            
            $sql = "SELECT ". implode(",", $cmtCols).", ";
            $sql .= "usr.user_name as userName, usr.email as email ";
            $sql .= "FROM `comments` as cmt, `users` as usr ";
            $sql .= "WHERE cmt.article_id = :articleId ";
            $sql .= "AND usr.id = cmt.user_id ";
            $sql .= "ORDER BY cmt.updated DESC LIMIT 100";        
            
            $sth = $this->pdo->prepare($sql);
            $sth->bindParam(':articleId', $articleId);
            $sth->execute();
            
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            
            die($ex->getMessage());
            return null;
        }
        
    }
}
