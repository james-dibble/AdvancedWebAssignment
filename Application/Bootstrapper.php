<?php
namespace Application;

class Bootstrapper 
{
    public static function BuildContainer()
    {
        $container = new \Library\Composition\Container();
        
        $crimeService = new \Application\Services\CrimeService();
        
        $container->Bind('Application\Services\ICrimeService', $crimeService);
        
        return $container;
    }
}

?>
