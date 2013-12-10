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
                "INSERT INTO `geographicreference`(`Name`) VALUES ('%s');", $objectToSave->id);
        
        $geographicLocationId = "SET @geographicReferenceId = (SELECT LAST_INSERT_ID());";
        
        $regionId = "SET @regionId = (SELECT @geographicReferenceId);";
        
        $countryId = sprintf("SET @countryId = 
            (
            SELECT `gr`.`id` FROM
                `country` `c`
            INNER JOIN `geographicreference` `gr`
                ON `gr`.`id` = `c`.`GeographicReference_Id`
            WHERE LOWER(`gr`.`Name`) = '%s'
            );", $referenceObjects['Country']->id);
        
        $regionQuery = 'INSERT INTO `region` (`GeographicReference_Id`, `Country_Id`)
            VALUES (@geographicReferenceId, @countryId);';
        
        return array($geographicLocationQuery, $geographicLocationId, $regionId, $countryId, $regionQuery);
    }

    public function GetChangeQueries($objectToSave, array $referenceObjects)
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