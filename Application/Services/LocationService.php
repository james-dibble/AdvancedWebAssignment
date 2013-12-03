<?php
namespace Application\Services;

class LocationService implements \Application\Services\ILocationService
{
    private $_persitence;
    
    public function __construct(\Library\Persistence\IPersistenceManager $persistence)
    {
        $this->_persitence = $persistence;
    }
    
    public function GetAllRegions()
    {
        $regions = $this->_persitence->GetCollection(
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('Application\Models\Domain\Region'), array()));
        
        return $regions;
    }    
}
?>