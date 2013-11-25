<?php
function AutoLoader($classname)
{    
    $fullPath = '..\\' . $classname . '.php';
            
    if(file_exists($fullPath))
    {
        include_once $fullPath;
    }
}

spl_autoload_register('AutoLoader');
?>
