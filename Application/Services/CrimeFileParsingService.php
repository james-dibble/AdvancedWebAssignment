<?php

namespace Application\Services;

class CrimeFileParsingService implements ICrimeFileParsingService
{
    const locationId = 0;
    const homocide = 5;
    const violenceWithInjury = 6;
    const violenceWithoutInjury = 7;
    const sexualOffenses = 8;
    const robbery = 9;
    const theftOffenses = 10;
    const domesticBurglary = 12;
    const nonDomesticBurglary = 13;
    const vehicleOffenses = 14;
    const theftFromPerson = 15;
    const bicycleTheft = 16;
    const shoplifting = 17;
    const miscTheft = 18;
    const criminalDamageAndArson = 19;
    const drugOffenses = 21;
    const possesionOfWeapons = 22;
    const publicOrderOffenses = 23;
    const miscCrimes = 24;
    const fruad = 26;

    private static $_countries = array('England', 'Wales');
    private static $_nationals = array('British Transport Police', 'Action Fraud1');
    
    private $_persistence;
    private $_crimeTypes;
    
    public function __construct(\Library\Persistence\IPersistenceManager $persistence)
    {
        $this->_persistence = $persistence;
        $this->_crimeTypes = array();
    }

    public function ParseFile(array $fileContents)
    {       
        $this->_crimeTypes = $this->_persistence->GetCollection(
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\CrimeStatisticType'), array()));
        
        $statistics = new \Application\Models\Domain\StatisticsCollection();

        $currentCountry = new \Application\Models\Domain\Country();
        $currentRegion = new \Application\Models\Domain\Region();

        foreach ($fileContents as $row)
        {
            if (CrimeFileParsingService::IsCountryRow($row))
            {
                $currentCountry->name = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];

                // Wales is weird, so we make Wales a region too
                if (count($currentCountry->regions) == 0)
                {
                    $currentRegion->name = $currentCountry->name;

                    array_push($currentCountry->regions, $currentRegion);
                }

                array_push($statistics->countires, $currentCountry);

                $currentCountry = new \Application\Models\Domain\Country();
                continue;
            }

            if (CrimeFileParsingService::IsRegionRow($row))
            {
                $regionName = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];
                $currentRegion->name = str_ireplace(' region', '', $regionName);

                array_push($currentCountry->regions, $currentRegion);

                $currentRegion = new \Application\Models\Domain\Region();
                continue;
            }

            if (CrimeFileParsingService::IsNationalRow($row))
            {
                // A national is nearly an area, so much so we can use the same function
                // to extract its statistics
                $national = $this->ParseArea($row);
                
                array_push($statistics->nationals, $national);
                
                continue;
            }

            $area = $this->ParseArea($row);

            if ($area != null)
            {
                array_push($currentRegion->areas, $area);
            }
        }
        return $statistics;
    }

    private function ParseArea($row)
    {
        if (preg_match('/^,+$/', $row))
        {
            return null;
        }

        // Match a statistics row.
        if (!preg_match('/^([1A-Za-z,\\-" ]+)((([,]+)(([\\d]{1,3})|([\\.]{2})|(["]{1}[\\d]{1,3}[,]{1}[\\d]{3}["]{1})))+)(\r\n|[\r\n])*$/', $row))
        {
            return null;
        }
        
        $lineContents = CrimeFileParsingService::SplitRow($row);
        
        $area = null;
        
        if (CrimeFileParsingService::IsNationalRow($row))
        {
            $area = new \Application\Models\Domain\National();
        }
        else
        {
            $area = new \Application\Models\Domain\Area();
        }
        
        $area->crimeStatistics = array();
        $area->name = $lineContents[CrimeFileParsingService::locationId];

        try
        {
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::homocide], $this->GetCrimeType("homocide"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::violenceWithInjury], $this->GetCrimeType("violenceWithInjury"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::violenceWithoutInjury], $this->GetCrimeType("violenceWithoutInjury"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::sexualOffenses], $this->GetCrimeType("sexualOffenses"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::robbery], $this->GetCrimeType("robbery"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::theftOffenses], $this->GetCrimeType("theftOffenses"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::domesticBurglary], $this->GetCrimeType("domesticBurglary"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::nonDomesticBurglary], $this->GetCrimeType("nonDomesticBurglary"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::vehicleOffenses], $this->GetCrimeType("theftFromPerson"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::bicycleTheft], $this->GetCrimeType("bicycleTheft"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::shoplifting], $this->GetCrimeType("shoplifting"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::miscTheft], $this->GetCrimeType("miscTheft"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::criminalDamageAndArson], $this->GetCrimeType("criminalDamageAndArson"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::drugOffenses], $this->GetCrimeType("drugOffenses"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::possesionOfWeapons], $this->GetCrimeType("possesionOfWeapons"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::publicOrderOffenses], $this->GetCrimeType("publicOrderOffenses"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::miscCrimes], $this->GetCrimeType("miscCrimes"), $area));
            array_push($area->crimeStatistics, new \Application\Models\Domain\CrimeStatistic($lineContents[CrimeFileParsingService::fruad], $this->GetCrimeType("fruad"), $area));
        }
        catch (Exception $ex)
        {
            return null;
        }

        return $area;
    }
    
    private function GetCrimeType($name)
    {
        foreach($this->_crimeTypes as $crimeType)
        {
            if(strtolower($crimeType->name) == strtolower($name))
            {
                return $crimeType;
            }
        }
    }

    private static function SplitRow($row)
    {
        $lineContents = array();

        foreach (str_getcsv($row) as $element)
        {
            array_push($lineContents, str_replace('..', '0', str_replace(',', '', $element)));
        }

        return $lineContents;
    }

    private static function IsCountryRow($row)
    {
        $possibleCountry = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];

        return CrimeFileParsingService::in_arrayi($possibleCountry, CrimeFileParsingService::$_countries);
    }

    private static function IsRegionRow($row)
    {
        $possibleRegion = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];

        return preg_match('/^[A-Za-z ]+ Region$/', $possibleRegion);
    }

    private static function IsNationalRow($row)
    {
        $possibleNational = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];

        return CrimeFileParsingService::in_arrayi($possibleNational, CrimeFileParsingService::$_nationals);
    }

    // From: http://uk.php.net/manual/en/function.in-array.php#89256
    private static function in_arrayi($needle, $haystack)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }

}
?>