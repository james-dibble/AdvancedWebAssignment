<?php
namespace Application\Persistence\Mapping;

class CountryMapper implements \Library\Persistence\IMapper
{
    private $_persistence;
    
    public function __construct(\Library\Persistence\IPersistenceManager $persistence)
    {
        $this->_persistence = $persistence;
    }
    
    public function GetAddQueries($objectToSave, array $referenceObjects)
    {
    }

    public function GetChangeQueries($objectToSave, array $referenceObjects)
    {
        
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        $baseQuery = 
                "SELECT `gr`.`Id`, `gr`.`Name` FROM `countrys` `c`
                 INNER JOIN 
                    `geograpic_references` `gr`
                    ON `c`.`GeographicReference_Id` = `gr`.`Id`";
        
        if($searcher->HasKey('ByName'))
        {
            $query = 
               sprintf("%s WHERE LOWER(`gr`.`name`) = LOWER(%s)", $baseQuery, $searcher->GetKey('ByName'));
                    
            return $query;
        }
                
        return $baseQuery;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\Country');
    }

    public function MapObject($results)
    {  
        $mappedObject = new \Application\Models\Domain\Country();
        
        $mappedObject->id = $results->Id;
        $mappedObject->name = $results->Name;
        
        $regions = $this->_persistence->Get(
                new \ReflectionClass('\Application\Models\Domain\Region'),
                array('ForCountry' => $mappedObject->id));
        
        $mappedObject->regions = $regions;
        
        return $mappedObject;
    }  
    
    public function GetDeleteQueries($objectToSave = null, \Library\Persistence\IPersistenceSearcher $searcher = null) 
    {
        if($searcher != null && $searcher->HasKey('Clear'))
        {
            $query = 'DELETE FROM `geographic_references` `gr` WHERE `gr`.`Id` IN (SELECT FROM `countrys` `a`);';
            
            return array($query);
        }
    }
}

?>
