<?php
namespace Library\Routing;

class Router
{
    const scriptTarget = 'Public/index.php';
    
    private static $_contextPath;
    
    public static function Dispatch()
    {
        try
        {
            // Use the output buffer so we can clear the output stream
            // if something goes wrong
            ob_start();
            $route = trim(str_replace(Router::GetContextPath(), '', $_SERVER['REQUEST_URI']), '/');
            $routeParameters = array_filter(explode('/', $route), 'strlen');
            $requestContext = Router::DetermineRequestContext($routeParameters);
            $controllerName = $requestContext->GetController();

            $controller = Router::CreateController($controllerName);

            $controller->ProcessRequest($requestContext);
        }
        catch(\Exception $ex)
        {
            // Something went wrong so clear the buffer so only our error
            // output is sent.
            ob_end_clean();
            $errorContext = new RequestContext('errors', 'index', $ex);
            
            $controllerName = $errorContext->GetController();
            $controller = Router::CreateController($controllerName);

            $controller->ProcessRequest($errorContext);
        }
    }
    
    private static function DetermineRequestContext($routeParameters)
    {
        if(count($routeParameters) === 0 || (count($routeParameters) === 1 && $routeParameters[0] === ''))
        {
            return new RequestContext('home', 'index', []);
        }
        
        if(count($routeParameters) === 1)
        {
            if(method_exists(Router::CreateController('home'), $routeParameters[0]))
            {
                return new RequestContext('home', $routeParameters[0], []);
            }
            
            return new RequestContext($routeParameters[0], 'index', []);
        }
        
        if(!method_exists(Router::CreateController($routeParameters[0]), $routeParameters[1]))
        {           
            return new RequestContext($routeParameters[0], 'index', array_slice($routeParameters, 1));
        }
        
        return new RequestContext(
                $routeParameters[0], 
                $routeParameters[1], 
                array_slice($routeParameters, 2));
    }
    
    private static function GetContextPath()
    {
        if(Router::$_contextPath == null)
        {
            Router::$_contextPath = trim(str_replace(Router::scriptTarget, '', $_SERVER['SCRIPT_NAME']), '/');
        }
        
        return Router::$_contextPath;
    }
    
    private static function CreateController($controllerName)
    {
        $fullyQualifiedControllerName = 'Application\\Controllers\\' . $controllerName . 'Controller';
        
        if(!class_exists($fullyQualifiedControllerName))
        {
            throw new \Library\Models\Errors\NotFoundException('Controller not found');
        }
        
        $controller = new $fullyQualifiedControllerName();
        
        return $controller;
    }
}
?>
