<?php
namespace Application\Persistence\Mapping;

class CountryMapper implements \Library\Persistence\IMapper
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
                `country` `c`
            INNER JOIN `geographicreference` `gr`
                ON `gr`.`id` = `c`.`GeographicReference_Id`';
        
        if($searcher->HasKey('ById'))
        {
            $query .= sprintf(" WHERE LOWER(`gr`.`name`) = LOWER('%s') LIMIT 1", $searcher->GetKey('ById'));
        }
             
        return $query;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\Country');
    }

    public function MapObject($results)
    {        
        $mappedObject = new \Application\Models\Domain\Country();
        
        $mappedObject->id = $results->name;
        
        $searchCriteria = array('ForCountry' => $results->id);
        
        $searcher = new \Library\Persistence\PersistenceSearcher(new \ReflectionClass('\Application\Models\Domain\Region'), $searchCriteria);
        
        $mappedObject->regions = $this->_persistence->GetCollection($searcher);
        
        return $mappedObject;
    }    
}

?>
