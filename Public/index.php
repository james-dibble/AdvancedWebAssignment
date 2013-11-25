<?php
    ini_set('display_errors','0');
    include_once '..\Application\AutoLoader.php';
         
    $controller = $_GET['controller'];
    $action = $_GET['action'];
        
    Library\Routing\Router::Dispatch($controller, $action);
?>