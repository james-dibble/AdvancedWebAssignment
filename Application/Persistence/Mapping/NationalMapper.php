<?php

namespace Application\Persistence\Mapping;

class NationalMapper implements \Library\Persistence\IMapper
{

    public function GetAddQueries($objectToSave)
    {
        $geographicLocationQuery =
                sprintf(
                "INSERT INTO `geographicreference`(`Name`) VALUES ('%s');
                SET @geographicReferenceId = (SELECT LAST_INSERT_ID);", $objectToSave->id);

        $crimeStatisticsQuery =
                sprintf(
                "INSERT INTO `crimestatistics`
                (
                    `Homicide`, 
                    `ViolenceWithInjury`,
                    `ViolenceWithoutInjury`,
                    `SexualOffenses`,
                    `Robbery`,
                    `TheftOffenses`,
                    `DomesticBurglary`,
                    `NonDomesticBurglary`,
                    `VehicleOffenses`,
                    `TheftFromPerson`,
                    `BicycleTheft`,
                    `Shoplifting`,
                    `MiscTheft`,
                    `CriminalDamageAndArson`,
                    `DrugOffenses`,
                    `PossesionOfWeapons`,
                    `PublicOrderOffenses`,
                    `MiscCrimes`,
                    `Fraud`
                )
                VALUES
                (
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s,
                    %s
                );
               SET @crimeStatsId = (SELECT LAST_INSERT_ID);", 
                        $objectToSave->crimeStatistics->homocide, 
                        $objectToSave->crimeStatistics->violenceWithInjury, 
                        $objectToSave->crimeStatistics->violenceWithoutInjury, 
                        $objectToSave->crimeStatistics->sexualOffenses, 
                        $objectToSave->crimeStatistics->robbery, 
                        $objectToSave->crimeStatistics->theftOffenses, 
                        $objectToSave->crimeStatistics->domesticBurglary, 
                        $objectToSave->crimeStatistics->nonDomesticBurglary, 
                        $objectToSave->crimeStatistics->vehicleOffenses, 
                        $objectToSave->crimeStatistics->theftFromPerson, 
                        $objectToSave->crimeStatistics->bicycleTheft, 
                        $objectToSave->crimeStatistics->shoplifting, 
                        $objectToSave->crimeStatistics->miscTheft, 
                        $objectToSave->crimeStatistics->criminalDamageAndArson, 
                        $objectToSave->crimeStatistics->drugOffenses, 
                        $objectToSave->crimeStatistics->possesionOfWeapons, 
                        $objectToSave->crimeStatistics->publicOrderOffenses, 
                        $objectToSave->crimeStatistics->miscCrimes, 
                        $objectToSave->crimeStatistics->fraud);

        $nationalQuery =
                'INSERT INTO `national`(`GeographicReference_Id`, `CrimeStatistics_Id`) 
                    VALUES(@geographicReferenceId, @crimeStatsId);';

        return array(sprintf('%s  %s  %s', $crimeStatisticsQuery, $geographicLocationQuery, $nationalQuery));
    }

    public function GetChangeQueries($objectToSave)
    {
        
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        $query =
                'SELECT `gr`.`id`, `gr`.`name`, 
                    `cs`.`Homicide`, 
                    `cs`.`ViolenceWithInjury`,
                    `cs`.`Homicide`,
                    `cs`.`ViolenceWithInjury`,
                    `cs`.`ViolenceWithoutInjury`,
                    `cs`.`SexualOffenses`,
                    `cs`.`Robbery`,
                    `cs`.`TheftOffenses`,
                    `cs`.`DomesticBurglary`,
                    `cs`.`NonDomesticBurglary`,
                    `cs`.`VehicleOffenses`,
                    `cs`.`TheftFromPerson`,
                    `cs`.`BicycleTheft`,
                    `cs`.`Shoplifting`,
                    `cs`.`MiscTheft`,
                    `cs`.`CriminalDamageAndArson`,
                    `cs`.`DrugOffenses`,
                    `cs`.`PossesionOfWeapons`,
                    `cs`.`PublicOrderOffenses`,
                    `cs`.`MiscCrimes`,
                    `cs`.`Fraud`
                  FROM
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
        $crimestatistics->violenceWithoutInjury = $results->ViolenceWithoutInjury;
        $crimestatistics->sexualOffenses = $results->SexualOffenses;
        $crimestatistics->robbery = $results->Robbery;
        $crimestatistics->theftOffenses = $results->TheftOffenses;
        $crimestatistics->domesticBurglary = $results->DomesticBurglary;
        $crimestatistics->nonDomesticBurglary = $results->NonDomesticBurglary;
        $crimestatistics->vehicleOffenses = $results->VehicleOffenses;
        $crimestatistics->theftFromPerson = $results->TheftFromPerson;
        $crimestatistics->bicycleTheft = $results->BicycleTheft;
        $crimestatistics->shoplifting = $results->Shoplifting;
        $crimestatistics->miscTheft = $results->MiscTheft;
        $crimestatistics->criminalDamageAndArson = $results->CriminalDamageAndArson;
        $crimestatistics->drugOffenses = $results->DrugOffenses;
        $crimestatistics->possesionOfWeapons = $results->PossesionOfWeapons;
        $crimestatistics->publicOrderOffenses = $results->PublicOrderOffenses;
        $crimestatistics->miscCrimes = $results->MiscCrimes;
        $crimestatistics->fraud = $results->Fraud;

        $mappedObject = new \Application\Models\Domain\National($crimeStatistics);

        $mappedObject->id = $results->name;

        return $mappedObject;
    }

}

?>
