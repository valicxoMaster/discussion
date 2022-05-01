<?php

namespace App\Controller;

use App\AbstractController;
use App\Model\Http\HttpRequst;


/**
 * Controller for work mit comment
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
        
        $body = $request->getBodyContent();                
        $articleId = $request->getParam();
        
        echo "->".$articleId."<br>";
        echo "<pre>" . print_r($_SERVER, true) . "</pre>";
        
        echo "BODY=><pre>".$body."<pre>\n";
        die("Add Action");        
    }
}
