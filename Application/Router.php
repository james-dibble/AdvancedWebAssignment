<?php
class Router
{
    public static function Dispatch()
    {
        $contextPath = explode('/', trim(trim($_SERVER['SCRIPT_NAME'], '/'), 'Public/index.php'));
        $route = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        foreach ($contextPath as $key => $val)
        {
            if ($val == $route[$key])
            {
                unset($route[$key]);
            }
        }
        
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
}
?>
