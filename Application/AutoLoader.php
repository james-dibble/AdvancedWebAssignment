<?php
function AutoLoader($classname)
{    
    $fullPath = dirname(__FILE__). '/../' . str_replace('\\', '/', $classname) . '.php';
        
    if(false)   
    {
        echo "$fullPath<br />";
    }
    
    if(file_exists($fullPath))
    {
        include_once $fullPath;
    }
}

spl_autoload_register('AutoLoader');
?>
