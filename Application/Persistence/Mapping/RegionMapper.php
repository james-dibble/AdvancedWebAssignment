<?php
namespace Application\Persistence\Mapping;

class RegionMapper implements \Library\Persistence\IMapper
{
    private $_persistence;
    
    public function __construct(\Library\Persistence\IPersistenceManager $persistence)
    {
        $this->_persistence = $persistence;
    }
    
    public function GetAddQueries($objectToSave)
    {
        
    }

    public function GetChangeQueries($objectToSave)
    {
        
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        if($searcher->HasKey('ForCountry'))
        {
            return sprintf('GetRegionForCountry(%s)', $searcher->GetKey('ForCountry'));
        }
        
        return 'GetAllRegions()';
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\Region');
    }

    public function MapObject($results)
    {
        $mappedObject = new \Application\Models\Domain\Region();
        
        $mappedObject->id = $results['name'];
        
        $searchCriteria = array('ForRegion' => $results['id']);
        
        $searcher = new \Library\Persistence\PersistenceSearcher(new \ReflectionClass('\Application\Models\Domain\Area'), $searchCriteria);
        
        $mappedObject->areas = $this->_persistence->GetCollection($searcher);
        
        return $mappedObject;
    }    
}
?>