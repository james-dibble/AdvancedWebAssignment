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
        $query = 
            'SELECT `gr`.`id`, `gr`.`name` FROM
                `region` `r`
            INNER JOIN `geographicreference` `gr`
                ON `gr`.`id` = `r`.`GeographicReference_Id`';
        
        if($searcher->HasKey('ForCountry'))
        {
            $query .= sprintf(' WHERE `r`.`Country_Id` = %d', $searcher->GetKey('ForCountry'));
        }
        
        if($searcher->HasKey('ById'))
        {
            $query .= sprintf(" WHERE LOWER(`gr`.`name`) = LOWER('%s')", $searcher->GetKey('ById'));
        }
                        
        return $query;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\Region');
    }

    public function MapObject($results)
    {
        $mappedObject = new \Application\Models\Domain\Region();
        
        $mappedObject->id = $results->name;
        
        $searchCriteria = array('ForRegion' => $results->id);
        
        $searcher = new \Library\Persistence\PersistenceSearcher(new \ReflectionClass('\Application\Models\Domain\Area'), $searchCriteria);
        
        $mappedObject->areas = $this->_persistence->GetCollection($searcher);
        
        return $mappedObject;
    }    
}
?>