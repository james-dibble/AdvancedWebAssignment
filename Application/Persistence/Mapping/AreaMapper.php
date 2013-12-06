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
                  `area` `a`
                INNER JOIN `geographicreference` `gr`
                  ON `gr`.`id` = `a`.`GeographicReference_Id`
                INNER JOIN `crimestatistics` `cs`
                  ON `a`.`CrimeStatistics_Id` = `cs`.`id`';

        if ($searcher->HasKey('ForRegion'))
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

        $mappedObject = new \Application\Models\Domain\Area($crimeStatistics);

        $mappedObject->id = $results->name;

        return $mappedObject;
    }

}

?>
