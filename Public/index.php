<?php
#ini_set('display_errors', '0');

define('CONTEXT_PATH', '/~j3-dibble/atwd/', true);
define('SCHEMA_PATH', 'http://www.cems.uwe.ac.uk/~j3-dibble/atwd/crimes/', true);

include_once dirname(__FILE__) . '/../Application/AutoLoader.php';

$container = \Application\Bootstrapper::BuildContainer();

$router = new \Library\Routing\Router($container);

$controller = $_GET['controller'];
$action = $_GET['action'];
$noCache = false;

if(isset($_GET['noCache']))
{
    $noCache = $_GET['noCache'];
}

$router->Dispatch($controller, $action, $noCache);
?>