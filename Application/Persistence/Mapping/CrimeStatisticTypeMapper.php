<?php
namespace Application\Persistence\Mapping;

class CrimeStatisticTypeMapper implements \Library\Persistence\IMapper
{
    public function GetAddQueries($objectToSave, array $refernceObjects)
    {
        $query = sprintf(
                "INSERT INTO `crimestatistictypes`(`name`, `abbreviation`) VALUES ('%s', '%s');",
                $objectToSave->name,
                $objectToSave->abbreviation);
        
        return $query;
    }

    public function GetChangeQueries($objectToSave, array $referenceObjects)
    {
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        $baseQuery = 
                "SELECT `id`, `name`, `abbreviation` FROM `crimestatistictypes`";
        
        if($searcher->HasKey('ById'))
        {
            return sprintf("%s WHERE `id` == %s", $baseQuery, $searcher->GetKey('ById'));
        }
        
        if($searcher->HasKey('name'))
        {
            return sprintf("%s WHERE LOWER(`name`) == LOWER(%s)", $baseQuery, $searcher->GetKey('name'));
        }
        
        if($searcher->HasKey('abbreviation'))
        {
            return sprintf("%s WHERE LOWER(`abbreviation`) == LOWER(%s)", $baseQuery, $searcher->GetKey('abbreviation'));
        }
        
        return $baseQuery;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\CrimeStatisticType');
    }

    public function MapObject($results)
    {
        $mappedObject = new \Application\Models\Domain\CrimeStatisticType();
        
        $mappedObject->id = $results->id;
        $mappedObject->name = $results->name;
        $mappedObject->abbreviation = $results->abbreviation;
        
        return $mappedObject;
    }    
}
?>