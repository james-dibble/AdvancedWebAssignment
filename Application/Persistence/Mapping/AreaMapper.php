<?php

namespace Application\Persistence\Mapping;

class AreaMapper implements \Library\Persistence\IMapper
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
        
        $areaQuery =
                sprintf('INSERT INTO `areas`(`GeographicReference_Id`, `Region_Id`) 
                    VALUES(@geographicReferenceId, %s)', $objectToSave->region->id);

        return array(
            $geographicLocationQuery, 
            $geographicLocationId, 
            $areaQuery);
    }

    public function GetChangeQueries($objectToSave, array $refernceObjects)
    {
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        $baseQuery = 
                "SELECT `gr`.`Id`, `gr`.`Name` FROM `areas` `a`
                 INNER JOIN 
                    `geographic_references` `gr`
                    ON `a`.`GeographicReference_Id` = `gr`.`Id`";
        
        if($searcher->HasKey('ByName'))
        {
            $query = 
               sprintf("%s WHERE LOWER(`gr`.`name`) = LOWER('%s')", $baseQuery, $searcher->GetKey('ByName'));
                    
            return $query;
        }
        
        if($searcher->HasKey('ForRegion'))
        {
            $query = 
               sprintf("%s WHERE `a`.`Region_Id` = '%s'", $baseQuery, $searcher->GetKey('ForRegion'));
                                
            return $query;
        }
        
        return $baseQuery;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\Area');
    }

    public function MapObject($results, \Library\Persistence\IPersistenceSearcher $searcher)
    {
        $mappedObject = new \Application\Models\Domain\Area();
        
        $mappedObject->id = $results->Id;
        $mappedObject->name = $results->Name;
        
        $statistics = $this->_persistence->GetCollection(new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\CrimeStatistic'),
                array('ForArea' => $mappedObject->id)));
        
        if(!$searcher->HasKey('ForRegion'))
        {
            $region = $this->_persistence->Get(new \Library\Persistence\PersistenceSearcher(
                   new \ReflectionClass('\Application\Models\Domain\Region'),
                   array('ForArea' => $mappedObject->id)));   
            $mappedObject->region = $region;
        }
        
        $mappedObject->crimeStatistics = $statistics;
        
        return $mappedObject;
    }

    public function GetDeleteQueries($objectToSave = null, \Library\Persistence\IPersistenceSearcher $searcher = null) 
    {
        if($searcher != null && $searcher->HasKey('Clear'))
        {
            $query = 'DELETE FROM `areas`;';
            
            return array($query);
        }
        
        if($objectToSave != null)
        {
            $statisticsQuery = 
                sprintf("DELETE FROM `crime_statistics` WHERE `GeographicReference_Id` = '%s';", $objectToSave->id);
            
            $areaQuery =
                sprintf("DELETE FROM `areas` WHERE `GeographicReference_Id` = '%s';", $objectToSave->id);
            
            $geographicReferenceQuery =
                sprintf("DELETE FROM `geographic_references` WHERE `Id` = '%s';", $objectToSave->id);
            
            return array($statisticsQuery, $areaQuery, $geographicReferenceQuery);
        }
    }
}
?>