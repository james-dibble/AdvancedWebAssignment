<?php
namespace Application\Persistence\Mapping;

class CrimeStatisticMapper implements \Library\Persistence\IMapper
{
    private $_persistence;
    
    public function __construct(\Library\Persistence\IPersistenceManager $persistence)
    {
        $this->_persistence = $persistence;
    }
    
    public function GetAddQueries($objectToSave, array $refernceObjects)
    {
        $query =
            sprintf("INSERT INTO `crime_statistics`(`Area_Id`, `CrimeStatisticType_Id`, `Value`) VALUES (%s, %s, %s);",
                    $objectToSave->area->id,
                    $objectToSave->type->id,
                    $objectToSave->value);
        
        return array($query);
    }

    public function GetChangeQueries($objectToSave, array $referenceObjects)
    {
        $query = 
                sprintf(
                        "UPDATE `crime_statistics` SET `Value` = '%s' WHERE `Area_Id` = '%s' AND `CrimeStatisticType_Id` = '%s'",
                        $objectToSave->value,
                        $objectToSave->area->id,
                        $objectToSave->type->id);
        
        return array($query);
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        $baseQuery = "SELECT `CrimeStatisticType_Id` AS `TypeId`, `Value` FROM `crime_statistics`";
        
        if($searcher->HasKey('ForArea'))
        {
            $query = sprintf("%s WHERE `Area_Id` = %s", $baseQuery, $searcher->GetKey('ForArea'));
            
            return $query;
        }
        
        return $baseQuery;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\CrimeStatistic');
    }

    public function MapObject($results, \Library\Persistence\IPersistenceSearcher $searcher)
    {
        $type = $this->_persistence->Get(new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\CrimeStatisticType'), 
                array('ById' => $results->TypeId)));
        
        $mappedObject = new \Application\Models\Domain\CrimeStatistic($results->Value, $type);
        
        return $mappedObject;
    }  
    
    public function GetDeleteQueries($objectToSave = null, \Library\Persistence\IPersistenceSearcher $searcher = null) 
    {
        if($searcher != null && $searcher->HasKey('Clear'))
        {
            $query = 'DELETE FROM `crime_statistics`;';
            
            return array($query);
        }
    }
}
?>