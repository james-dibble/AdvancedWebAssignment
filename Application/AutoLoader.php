<?php

function AutoLoader($classname)
{
    $fullPath = dirname(__FILE__) . '/../' . str_replace('\\', '/', $classname) . '.php';

    if (false)
    {
        echo "$fullPath<br />";
    }

    if (file_exists($fullPath))
    {
        include_once $fullPath;
    }
}

function shutDownFunction()
{
    $error = error_get_last();

    if ($error != null)
    {
        $errorController = new \Application\Controllers\ErrorsController();

        $actionResult = $errorController->Error(new \Exception($error['message']));

        $actionResult->DoAction();
    }
}

register_shutdown_function('shutDownFunction');

spl_autoload_register('AutoLoader');
?>
