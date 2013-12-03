<?php
namespace Application\Persistence\Mapping;

class AreaMapper implements \Library\Persistence\IMapper
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
    `area` `a`
  INNER JOIN `geographicreference` `gr`
    ON `gr`.`id` = `a`.`GeographicReference_Id`
  INNER JOIN `crimestatistics` `cs`
    ON `a`.`CrimeStatistics_Id` = `cs`.`id`';
        
        if($searcher->HasKey('ForRegion'))
        {
            $query .= sprintf(' WHERE `a`.`Region_Id` = %d', $searcher->GetKey('ForRegion'));
        }
        
        return $query;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\Area');
    }

    public function MapObject($results)
    {      
        $crimeStatistics = new \Application\Models\Domain\CrimeStatistics();
                
        $crimeStatistics->homocide = $results->Homicide;
        $crimeStatistics->violenceWithInjury = $results->ViolenceWithInjury;
        
        $mappedObject = new \Application\Models\Domain\Area($crimeStatistics);
        
        $mappedObject->id = $results->name;
        
        return $mappedObject;
    }    
}

?>
