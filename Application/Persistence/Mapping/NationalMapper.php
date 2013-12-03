<?php
namespace Application\Persistence\Mapping;

class NationalMapper implements \Library\Persistence\IMapper
{
    public function GetAddQueries($objectToSave)
    {
        
    }

    public function GetChangeQueries($objectToSave)
    {
        
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        $query = 
                'SELECT `gr`.`id`, `gr`.`name`, `cs`.`Homicide`, `cs`.`ViolenceWithInjury` FROM
                    `national` `n`
                  INNER JOIN `geographicreference` `gr`
                    ON `gr`.`id` = `n`.`GeographicReference_Id`
                  INNER JOIN `crimestatistics` `cs`
                    ON `n`.`CrimeStatistics_Id` = `cs`.`id`';
        
        return $query;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\National');
    }

    public function MapObject($results)
    {
        $crimeStatistics = new \Application\Models\Domain\CrimeStatistics();
                
        $crimeStatistics->homocide = $results->Homicide;
        $crimeStatistics->violenceWithInjury = $results->ViolenceWithInjury;
        
        $mappedObject = new \Application\Models\Domain\National($crimeStatistics);
        
        $mappedObject->id = $results->name;
        
        return $mappedObject;
    }    
}

?>
