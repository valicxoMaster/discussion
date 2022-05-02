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
use Exception;

/**
 * Controller for a work with a comment
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
     * Checks if article mathes input data to save a comment
     * 
     * @param HttpRequst $request
     * @param array $inputData
     * @return void
     */
    protected static function checkInput(HttpRequst $request, array $inputData) :void
    {
        $articleId = intval($request->getParam());            

        if ($articleId !== intval($inputData["articleId"])) {

            HttpResponse::create()
                ->setCode(404)
                ->setData("The comment has not been found.")
                ->send();                
        }        
    }

    /**
     * HTTP Post method to add comment [/comment/add/{articleId}]
     * 
     * @param HttpRequst $request
     */
    public function addAction(HttpRequst $request) : void
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
                    ->setData("The comment cannot be saved.")
                    ->send();
        }
    }
    
    /**
     * HTTP GET method to list last 100 comments [/comment/list/{articleId}]
     * 
     * @param HttpRequst $request
     */    
    public function listAction(HttpRequst $request) : void
    {
        try {
     
            $request->check("GET", "");
       
            $articleId = intval($request->getParam());    
            $recs = $this->commentRepo->list($articleId);
            
            HttpResponse::create()
                    ->setCode(200)
                    ->setData($recs)
                    ->send();
            
        } catch (Exception $ex) {
            
            HttpResponse::create()
                    ->setCode(400)
                    ->setData("Comments of the article can not be delivered.")
                    ->send();
        }
    }    
    
    /**
     * HTTP GET method to list last 100 comments [/comment/update/{articleId}]
     * 
     * @param HttpRequst $request
     */    
    public function updateAction(HttpRequst $request) : void
    {
        try {
            
            $request->check("PUT");

            $commentModel = new Comment();
            $inputData = json_decode($request->getBodyContent(), true);                

            self::checkInput($request, $inputData);
            
            $commentModel->setData($inputData);         
            
            if (!$this->commentRepo->update($commentModel)) {
                
                throw new StorageException("Comment cannot be updated.");
            }

            HttpResponse::create()
                    ->setCode(200)
                    ->setData("The comment has successfully updated.")
                    ->send();
            
        } catch (Exception $ex) {

            HttpResponse::create()
                    ->setCode(400)
                    ->setData("The comment cannot be saved.")
                    ->send();
        }
    }    
    
    /**
     * HTTP GET method to list last 100 comments [/comment/delete/{articleId}]
     * 
     * @param HttpRequst $request
     */    
    public function deleteAction(HttpRequst $request) : void
    {
        try {
            
            $request->check("DELETE");

            $commentModel = new Comment();
            $inputData = json_decode($request->getBodyContent(), true);                

            self::checkInput($request, $inputData);

            $commentModel->setData($inputData);         
            
            if (!$this->commentRepo->delete($commentModel)) {
                
                throw new StorageException("Comment cannot be updated.");
            }

            HttpResponse::create()
                    ->setCode(200)
                    ->setData("The comment has successfully deleted.")
                    ->send();
            
        } catch (Exception $ex) {

            HttpResponse::create()
                    ->setCode(400)
                    ->setData("The comment cannot be saved.")
                    ->send();
        }
    }    
    
}
