<?php

namespace App\Controller;

use App\AbstractController;
use App\Model\Http\HttpRequst;
use App\Model\Contract\Comment;
use App\Model\Http\HttpResponse;
/**
 * Controller for a work a comment
 *
 * @author Valeriy Khomenko
 */
class CommentController extends AbstractController
{    

        /**
     * HTTP Post method to add comment
     * 
     * @param HttpRequst $request
     */
    public function addAction(HttpRequst $request)
    {   
        $request->check("POST");
        
        $model = new Comment();
        $inputData = json_decode($request->getBodyContent(), true);                
        $model->setData($inputData);
        
        
        
        HttpResponse::create()
                ->setCode(205)
                ->setData($model->toStdObject())
                ->send();
        
        $articleId = $request->getParam();
        
        
        
        //create model
        
        echo "->".$articleId."<br>";
        echo "<pre>" . print_r($_SERVER, true) . "</pre>";
        
        echo "BODY=>\n";
        echo "<pre>" . print_r($model, true) . "</pre>";

        die("Add Action");        
    }
}
