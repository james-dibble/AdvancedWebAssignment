<?php
namespace Application\Persistence\Mapping;

class RegionMapper implements \Library\Persistence\IMapper
{
    private $_persistence;
    
    public function __construct(\Library\Persistence\IPersistenceManager $persistence)
    {
        $this->_persistence = $persistence;
    }
    
    public function GetAddQueries($objectToSave, array $referenceObjects)
    {
        $geographicLocationQuery =
                sprintf(
                "INSERT INTO `geographic_references`(`Name`) VALUES ('%s');", $objectToSave->name);
        
        $geographicLocationId = "SET @geographicReferenceId = (SELECT LAST_INSERT_ID());";
                
        $regionQuery = sprintf("INSERT INTO `regions` (`GeographicReference_Id`, `Country_Id`)
            VALUES (@geographicReferenceId, %s);", $objectToSave->country->id);
        
        echo $regionQuery;
        
        return array($geographicLocationQuery, $geographicLocationId, $regionQuery);
    }

    public function GetChangeQueries($objectToSave, array $referenceObjects)
    {
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        $baseQuery = 
                "SELECT `gr`.`Id`, `gr`.`Name` FROM `regions` `r`
                 INNER JOIN 
                    `geographic_references` `gr`
                    ON `r`.`GeographicReference_Id` = `gr`.`Id`";
        
        if($searcher->HasKey('ByName'))
        {
            $query = 
               sprintf("%s WHERE LOWER(`gr`.`name`) = LOWER('%s')", $baseQuery, $searcher->GetKey('ByName'));
                    
            return $query;
        }
        
        if($searcher->HasKey('ForCountry'))
        {
            $query = 
               sprintf("%s WHERE `r`.`Country_Id` = %s", $baseQuery, $searcher->GetKey('ForCountry'));
                    
            return $query;
        }
        
        return $baseQuery;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\Region');
    }

    public function MapObject($results)
    {
        $mappedObject = new \Application\Models\Domain\Region();
        
        $mappedObject->id = $results->Id;
        $mappedObject->name = $results->Name;
        
        $areas = $this->_persistence->Get(
                new \ReflectionClass('\Application\Models\Domain\Area'),
                array('ForRegion' => $mappedObject->id));
        
        $mappedObject->areas = $areas;
        
        return $mappedObject;
    } 
    
    public function GetDeleteQueries($objectToSave = null, \Library\Persistence\IPersistenceSearcher $searcher = null) 
    {
        if($searcher != null && $searcher->HasKey('Clear'))
        {
            $query = 'DELETE FROM `geographic_references` WHERE `Id` IN (SELECT `GeographicReference_Id` FROM `regions`);';
            
            return array($query);
        }
    }
}
?>