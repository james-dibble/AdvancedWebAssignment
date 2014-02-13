<?php

namespace Application\Persistence\Mapping;

class NationalMapper implements \Library\Persistence\IMapper
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

        $nationalQuery = 'INSERT INTO `nationals`(`GeographicReference_Id`) 
            VALUES(@geographicReferenceId)';

        return array(
            $geographicLocationQuery,
            $geographicLocationId,
            $nationalQuery);
    }

    public function GetChangeQueries($objectToSave, array $referenceObjects)
    {
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        $baseQuery =
                "SELECT `gr`.`Id`, `gr`.`Name` FROM `nationals` `n`
                 INNER JOIN 
                    `geographic_references` `gr`
                    ON `n`.`GeographicReference_Id` = `gr`.`Id`";

        if ($searcher->HasKey('ByName'))
        {
            $query =
                    sprintf("%s WHERE LOWER(`gr`.`name`) = LOWER('%s')", $baseQuery, $searcher->GetKey('ByName'));

            return $query;
        }

        return $baseQuery;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\National');
    }

    public function MapObject($results, \Library\Persistence\IPersistenceSearcher $searcher)
    {
        $mappedObject = new \Application\Models\Domain\National();
        
        $mappedObject->id = $results->Id;
        $mappedObject->name = $results->Name;

        $statistics = $this->_persistence->GetCollection(new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\CrimeStatistic'), array('ForArea' => $mappedObject->id)));
        
        $mappedObject->crimeStatistics = $statistics;

        return $mappedObject;
    }

    public function GetDeleteQueries($objectToSave = null, \Library\Persistence\IPersistenceSearcher $searcher = null)
    {
        if($searcher != null && $searcher->HasKey('Clear'))
        {
            $query = 'DELETE FROM `nationals`;';
            
            return array($query);
        }
    }

}

?>