<?php
class Router
{
    const scriptTarget = 'Public/index.php';
    
    private static $_contextPath;
    
    public static function Dispatch()
    {
        $route = str_replace(Router::GetContextPath(), '', trim($_SERVER['REQUEST_URI'], '/'));
                
        $requestContext = Router::DetermineRequestContext($route);
        
        echo sprintf('Controller: %s, Action %s', $requestContext->GetController(), $requestContext->GetAction());
    }
    
    private static function DetermineRequestContext($routeParameters)
    {
        if(count($routeParameters) === 0)
        {
            return new RequestContext('home', 'index', []);
        }
        
        if(count($routeParameters) === 1)
        {
            return new RequestContext('home', $routeParameters[1], []);
        }
        
        return new RequestContext(
                $routeParameters[1], 
                $routeParameters[2], 
                array_slice($routeParameters, 2));
    }
    
    private static function GetContextPath()
    {
        if(Router::$_contextPath == null)
        {
            Router::$_contextPath = str_replace(Router::scriptTarget, '', trim($_SERVER['SCRIPT_NAME'], '/'));
        }
        
        return Router::$_contextPath;
    }
}
?>
