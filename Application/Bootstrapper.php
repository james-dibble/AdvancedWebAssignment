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
        
        $persistenceManager = new \Library\Persistence\MySqlPersistenceManager('mysql5.cems.uwe.ac.uk', 'fet10009689', 'jli798ik', $mapperDictionary);
        
        $areaMapper = new \Application\Persistence\Mapping\AreaMapper();
        $regionMapper = new \Application\Persistence\Mapping\RegionMapper($persistenceManager);
        $nationalMapper = new \Application\Persistence\Mapping\NationalMapper();
        $countryMapper = new \Application\Persistence\Mapping\CountryMapper($persistenceManager);
        
        $mapperDictionary->Add($areaMapper);
        $mapperDictionary->Add($regionMapper);
        $mapperDictionary->Add($nationalMapper);
        $mapperDictionary->Add($countryMapper);
        
        $container->Bind('\Library\Persistence\IPersistenceManager', $persistenceManager);
        
        $crimeService = new \Application\Services\CrimeService($persistenceManager);
        $container->Bind('Application\Services\ICrimeService', $crimeService);
        
        return $container;
    }
}
?>