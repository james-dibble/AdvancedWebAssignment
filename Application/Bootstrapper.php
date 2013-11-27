<?php
namespace Application;

class Bootstrapper 
{
    public static function BuildContainer()
    {        
        $container = new \Library\Composition\Container();
        
        $crimeService = new \Application\Services\CrimeService();
        $container->Bind('Application\Services\ICrimeService', $crimeService);
        
        $fileParser = new \Application\Services\CrimeFileParser();
        $container->Bind('Application\Services\ICrimeFileParsingService', $fileParser);
        
        return $container;
    }
}

?>
