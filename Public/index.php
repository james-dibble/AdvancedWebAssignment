<?php
    ini_set('display_errors','0');
    include_once '..\Application\AutoLoader.php';
         
    $container = \Application\Bootstrapper::BuildContainer();
    
    $router = new \Library\Routing\Router($container);
    
    $controller = $_GET['controller'];
    $action = $_GET['action'];
        
    $router->Dispatch($controller, $action);
?>