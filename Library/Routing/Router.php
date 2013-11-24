<?php
namespace Library\Routing;

class Router
{    
    public static function Dispatch($controllerName, $actionName)
    {
        try
        {
            // Use the output buffer so we can clear the output stream
            // if something goes wrong
            ob_start();

            $controller = Router::CreateController($controllerName);

            $controller->ProcessRequest($actionName);
        }
        catch(\Exception $ex)
        {
            // Something went wrong so clear the buffer so only our error
            // output is sent.
            ob_end_clean();
            
            $controller = Router::CreateController('errors');

            $controller->ProcessRequest('index', $ex);
        }
    }
    
    private static function CreateController($controllerName)
    {
        $fullyQualifiedControllerName = '\Application\\Controllers\\' . $controllerName . 'Controller';
        
        if(!class_exists($fullyQualifiedControllerName))
        {
            throw new \Library\Models\Errors\NotFoundException('Controller not found');
        }
        
        $controller = new $fullyQualifiedControllerName();
        
        return $controller;
    }
}
?>
