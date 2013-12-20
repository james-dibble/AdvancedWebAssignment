<?php
    ini_set('display_errors', '0');

    #define('CONTEXT_PATH', '/~j3-dibble/atwd/');
    define('CONTEXT_PATH', '/atwd/');
    include_once dirname(__FILE__) . '/../Application/AutoLoader.php';
             
    $container = \Application\Bootstrapper::BuildContainer();
    
    $router = new \Library\Routing\Router($container);
    
    $controller = $_GET['controller'];
    $action = $_GET['action'];
    
    $router->Dispatch($controller, $action);
?>
