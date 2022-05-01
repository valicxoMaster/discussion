<?php

namespace App;

use Dotenv\Dotenv;
use App\Exception\RouteException;
use App\Model\Http\HttpRequst;

/**
 * Class of an Application
 *
 * @author Valeriy Khomenko
 */
class Application {
    
    /**
     * protected constructor of the class Application
     */
    protected function __construct() 
    {        
    }
    
    /**
     * Loads all environments from the file .env
     * 
     * @return void
     */
    protected static function loadEnvs() : void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();        
    }
    
    /**
     * Parse route from uri
     * 
     * @return array
     */
    protected static function parseRouteFromUri() : array
    {
        $routeParts = explode("/", $_SERVER['REQUEST_URI']);                
        $controller = $routeParts[1];
        $action = $routeParts[2];
        
        if (empty($controller) || $controller === "client") {
            
            $uris = [
                $_SERVER['REQUEST_SCHEME'].'://',
                $_SERVER['HTTP_HOST'].'/',
                'client/index.html'
            ];
            
            header('Location: '. implode('', $uris));
        }
        
        return [
            "controller" => empty($controller)? "" : $controller,
            "action" => empty($action)? "" : $action,
            "param" => $routeParts[3]
        ];
    }
    
    /**
     * Run an action of a controller
     * 
     * @param array $route
     * @return void
     */
    protected static function runAction(array $route) : void 
    {
        $controller = ucwords($route["controller"]) . "Controller";
        $class = "\\App\\Controller\\" . $controller;
        $action = ucwords($route["action"])."Action";
        $file = __DIR__ . "/Controller/" . $controller. ".php";
        
        if (!file_exists($file)) {
            
            throw new RouteException(
                "The controller " . $controller . " has not been found"
            );
        }        
        
        $instance = new $class();
        
        if (!method_exists($instance, $action)) {
            
            throw new RouteException(
                "The method " . $action. " of the controller " . $controller 
                    . " has not been found"
            );
        }
        
        $request = new HttpRequst();
        $request->setRoute([
            'route' => $route,
            'path' => [
                'class' => $class,
                'file' => $file,
                'action' => $action
            ]
        ]);
        
        $instance->$action($request);
    }

    /**
     * Launches the application instance
     * 
     * @return void
     */
    public static function run() : void
    {
        self::loadEnvs();
        
        $route = self::parseRouteFromUri();
        self::runAction($route);
    }
}