<?php
namespace Application;

class Bootstrapper 
{
    public static function BuildContainer()
    {        
        $container = new \Library\Composition\Container();
                        
        $fileParser = new \Application\Services\CrimeFileParsingService();
        $container->Bind('Application\Services\ICrimeFileParsingService', $fileParser);
        
        $mapperDictionary = new \Library\Persistence\MapperDictionary();
        
        $persistenceManager = new \Library\Persistence\MySqlPersistenceManager('localhost', 'root', '', $mapperDictionary);
        
        $areaMapper = new Persistence\Mapping\AreaMapper();
        $regionMapper = new Persistence\Mapping\RegionMapper($persistenceManager);
        
        $mapperDictionary->Add($areaMapper);
        $mapperDictionary->Add($regionMapper);
        
        $container->Bind('\Library\Persistence\IPersistenceManager', $persistenceManager);
        
        $crimeService = new \Application\Services\CrimeService($persistenceManager);
        $container->Bind('Application\Services\ICrimeService', $crimeService);
        
        return $container;
    }
}

?>
