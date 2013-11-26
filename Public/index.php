<?php
    #ini_set('display_errors', '0');

    define('CONTEXT_PATH', '/atwd/');

    include_once '..\Application\Bootstrap.php';

    $controller = $_GET['controller'];
    $action = $_GET['action'];

    Library\Routing\Router::Dispatch($controller, $action);
?>