<?php
namespace Library\Routing;

class Router
{
    const scriptTarget = 'Public/index.php';
    
    private static $_contextPath;
    
    public static function Dispatch()
    {
        $route = trim(str_replace(Router::GetContextPath(), '', $_SERVER['REQUEST_URI']), '/');
        $routeParameters = array_filter(explode('/', $route), 'strlen');
        $requestContext = Router::DetermineRequestContext($routeParameters);
        $controllerName = $requestContext->GetController();
        
        $fullyQualifiedControllerName = 'Application\\Controllers\\' . $controllerName . 'Controller';
        
        $controller = new $fullyQualifiedControllerName();
        $controller->ProcessRequest($requestContext);
    }
    
    private static function DetermineRequestContext($routeParameters)
    {
        if(count($routeParameters) === 0 || (count($routeParameters) === 1 && $routeParameters[0] === ''))
        {
            return new RequestContext('home', 'index', []);
        }
        
        if(count($routeParameters) === 1)
        {
            return new RequestContext('home', $routeParameters[0], []);
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
}
?>
