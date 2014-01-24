<?php
namespace Application;

class Bootstrapper 
{
    public static function BuildContainer()
    {        
        $container = new \Library\Composition\Container();
                 
        $mapperDictionary = new \Library\Persistence\MapperDictionary();
        
        $persistenceManager = new \Library\Persistence\MySqlPersistenceManager('mysql5.cems.uwe.ac.uk', 'fet10009689', 'jli798ik', $mapperDictionary);
        #$persistenceManager = new \Library\Persistence\MySqlPersistenceManager('localhost', 'root', '', $mapperDictionary);
        
        $areaMapper = new \Application\Persistence\Mapping\AreaMapper($persistenceManager);
        $regionMapper = new \Application\Persistence\Mapping\RegionMapper($persistenceManager);
        $nationalMapper = new \Application\Persistence\Mapping\NationalMapper($persistenceManager);
        $countryMapper = new \Application\Persistence\Mapping\CountryMapper($persistenceManager);
        $crimeStatisticMapper = new \Application\Persistence\Mapping\CrimeStatisticMapper($persistenceManager);
        $crimeStatisticTypeMapper = new \Application\Persistence\Mapping\CrimeStatisticTypeMapper();
        
        $mapperDictionary->Add($areaMapper);
        $mapperDictionary->Add($regionMapper);
        $mapperDictionary->Add($nationalMapper);
        $mapperDictionary->Add($countryMapper);
        $mapperDictionary->Add($crimeStatisticMapper);
        $mapperDictionary->Add($crimeStatisticTypeMapper);
        
        $cache = new \Library\Caching\RequestCache();
        $container->Bind('Library\Caching\IRequestCache', $cache);
                       
        $fileParser = new \Application\Services\CrimeFileParsingService($persistenceManager);
        $container->Bind('Application\Services\ICrimeFileParsingService', $fileParser);
        
        $container->Bind('\Library\Persistence\IPersistenceManager', $persistenceManager);
        
        $crimeService = new \Application\Services\CrimeService($persistenceManager, $cache);
        $container->Bind('Application\Services\ICrimeService', $crimeService);
        
        $locationsService = new \Application\Services\LocationService($persistenceManager);
        $container->Bind('Application\Services\ILocationService', $locationsService);
                
        return $container;
    }
}
?>