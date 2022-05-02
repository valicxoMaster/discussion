<?php

namespace App\Controller;

use App\AbstractController;
use App\Model\Http\HttpRequst;
use App\Model\Contract\Comment;
use App\Model\Http\HttpResponse;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Model\Contract\PdoConfig;
use App\Exception\StorageException;

/**
 * Controller for a work a comment
 *
 * @author Valeriy Khomenko
 */
class CommentController extends AbstractController
{    
    /**
     * 
     * @var UserRepository
     */
    protected $userRepo;
    
    /**
     * 
     * @var CommentRepository
     */
    protected $commentRepo;


    public function __construct() 
    {
        $pdoConfig = PdoConfig::createFromEnvironment();
        $this->userRepo = new UserRepository($pdoConfig);
        $this->commentRepo = new CommentRepository($pdoConfig);
    }
    
    /**
     * Returns a found or created user ID
     * 
     * @param array $inputData
     * @return int
     * @throws StorageException
     */
    protected function findOrCreateUser(array $inputData) : int 
    {
        $user = $this->userRepo->findByEmail($inputData["email"]);
        
        if (empty($user)) {

            $userId = $this->userRepo->insert(
                $inputData["email"], 
                $inputData["userName"]
            );            
            
            if (empty($userId)) {

                throw new StorageException(
                    "User cannot be saved. Please check data."
                );
            }
            
            return $userId;
        }
        
        return $user["id"];
    } 

    /**
     * HTTP Post method to add comment
     * 
     * @param HttpRequst $request
     */
    public function addAction(HttpRequst $request)
    {   
        try {
            
            $request->check("POST");

            $commentModel = new Comment();
            $inputData = json_decode($request->getBodyContent(), true);                
            $inputData["articleId"] = intval($request->getParam());
            $inputData["userId"] = $this->findOrCreateUser($inputData);        
            $inputData["updated"] = date("Y-m-d H:i:s");

            $commentModel->setData($inputData);              
            $id = $this->commentRepo->insert($commentModel);
            $commentModel->setId($id);

            HttpResponse::create()
                    ->setCode(201)
                    ->setData($commentModel->toStdObject())
                    ->send();
            
        } catch (Exception $ex) {

            HttpResponse::create()
                    ->setCode(400)
                    ->setData($ex->getMessage())
                    ->send();
        }
    }
}
