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

        $areaQuery =
                sprintf('INSERT INTO `areas`(`GeographicReference_Id`, `Region_Id`) 
                    VALUES(@geographicReferenceId, %s)', $objectToSave->region->id);

        return array(
            $geographicLocationQuery,
            $geographicLocationId,
            $areaQuery);
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
                    ON `n`.`Area_Id` = `gr`.`Id`";

        if ($searcher->HasKey('ByName'))
        {
            $query =
                    sprintf("%s WHERE LOWER(`gr`.`name`) = LOWER(%s)", $baseQuery, $searcher->GetKey('ByName'));

            return $query;
        }

        return $baseQuery;
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\National');
    }

    public function MapObject($results)
    {
        $mappedObject = new \Application\Models\Domain\National();

        $mappedObject->id = $results->Id;
        $mappedObject->name = $results->Name;

        $statistics = $this->_persistence->Get(
                new \ReflectionClass('\Application\Models\Domain\CrimeStatistic'), array('ForArea' => $mappedObject->id));

        $mappedObject->crimeStatistics = $statistics;

        return $mappedObject;
    }

    public function GetDeleteQueries($objectToSave = null, \Library\Persistence\IPersistenceSearcher $searcher = null)
    {
        if ($searcher != null && $searcher->HasKey('Clear'))
        {
            $query = 'DELETE FROM `geographic_references` WHERE `Id` IN (SELECT `Area_Id` FROM `nationals`);';

            return array($query);
        }
    }

}

?>