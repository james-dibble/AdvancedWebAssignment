<?php
namespace Application\Persistence;
class DataSeeder 
{
    private static $crimeTypes = array(
        "Homocide" => "hom",
        "ViolenceWithInjury" => "vwi",
        "ViolenceWithoutInjury" => "vwoi",
        "SexualOffenses" => "so",
        "Robbery" => "rob",
        "TheftOffenses" => "th",
        "DomesticBurglary" => "db",
        "NonDomesticBurglary" => "ndb",
        "VehicleOffenses" => "vo",
        "TheftFromPerson" => "tfp",
        "BicycleTheft" => "bt",
        "Shoplifting" => "shop",
        "MiscTheft" => "mt",
        "CriminalDamageAndArson" => "cdaa",
        "DrugOffenses" => "do",
        "PossesionOfWeapons" => "pow",
        "PublicOrderOffenses" => "poo",
        "MiscCrimes" => "mc",
        "Fruad" => "frd"
    );
    
    static function ClearAndSeed(\Library\Persistence\IPersistenceManager $persistence)
    {
        echo "I AM CLEARING <br /><br />";
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\CrimeStatistic'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\CrimeStatisticType'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\National'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\Area'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\Region'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\Country'), 
                        array('Clear' => null)));
        
        $persistence->Commit();
        
        foreach (DataSeeder::$crimeTypes as $crimeTypeName => $abbreviation)
        {
            $newCrimeType = new \Application\Models\Domain\CrimeStatisticType();
            $newCrimeType->name = $crimeTypeName;
            $newCrimeType->abbreviation = $abbreviation;
            
            $persistence->Add($newCrimeType, array());
        }
        
        $persistence->Commit();
    }
}
?>