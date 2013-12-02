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

    public function ParseFile(array $fileContents)
    {
        $statistics = new \Application\Models\Domain\StatisticsCollection();

        $currentCountry = new \Application\Models\Domain\Country();
        $currentRegion = new \Application\Models\Domain\Region();

        foreach ($fileContents as $row)
        {
            if (CrimeFileParsingService::IsCountryRow($row))
            {
                $currentCountry->id = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];

                if (count($currentCountry->regions) == 0)
                {
                    $currentRegion->id = $currentCountry->id;

                    array_push($currentCountry->regions, $currentRegion);
                }

                array_push($statistics->countires, $currentCountry);

                $currentCountry = new \Application\Models\Domain\Country();
                continue;
            }

            if (CrimeFileParsingService::IsRegionRow($row))
            {
                $currentRegion->id = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];

                array_push($currentCountry->regions, $currentRegion);

                $currentRegion = new \Application\Models\Domain\Region();
                continue;
            }

            if (CrimeFileParsingService::IsNationalRow($row))
            {
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

        if (!preg_match('/^([1A-Za-z,\\-" ]+)((([,]+)(([\\d]{1,3})|([\\.]{2})|(["]{1}[\\d]{1,3}[,]{1}[\\d]{3}["]{1})))+)$/', $row))
        {
            return null;
        }

        $statistics = new \Application\Models\Domain\CrimeStatistics();

        $lineContents = CrimeFileParsingService::SplitRow($row);

        try
        {
            $statistics->homocide = $lineContents[CrimeFileParsingService::homocide];
            $statistics->violenceWithInjury = $lineContents[CrimeFileParsingService::violenceWithInjury];
            $statistics->violenceWithoutInjury = $lineContents[CrimeFileParsingService::violenceWithoutInjury];
            $statistics->sexualOffenses = $lineContents[CrimeFileParsingService::sexualOffenses];
            $statistics->robbery = $lineContents[CrimeFileParsingService::robbery];
            $statistics->theftOffenses = $lineContents[CrimeFileParsingService::theftOffenses];
            $statistics->domesticBurglary = $lineContents[CrimeFileParsingService::domesticBurglary];
            $statistics->nonDomesticBurglary = $lineContents[CrimeFileParsingService::nonDomesticBurglary];
            $statistics->vehicleOffenses = $lineContents[CrimeFileParsingService::vehicleOffenses];
            $statistics->theftFromPerson = $lineContents[CrimeFileParsingService::theftFromPerson];
            $statistics->bicycleTheft = $lineContents[CrimeFileParsingService::bicycleTheft];
            $statistics->shoplifting = $lineContents[CrimeFileParsingService::shoplifting];
            $statistics->miscTheft = $lineContents[CrimeFileParsingService::miscTheft];
            $statistics->criminalDamageAndArson = $lineContents[CrimeFileParsingService::criminalDamageAndArson];
            $statistics->drugOffenses = $lineContents[CrimeFileParsingService::drugOffenses];
            $statistics->possesionOfWeapons = $lineContents[CrimeFileParsingService::possesionOfWeapons];
            $statistics->publicOrderOffenses = $lineContents[CrimeFileParsingService::publicOrderOffenses];
            $statistics->miscCrimes = $lineContents[CrimeFileParsingService::miscCrimes];
            $statistics->fraud = $lineContents[CrimeFileParsingService::fruad];
        }
        catch (Exception $ex)
        {
            return null;
        }

        if (CrimeFileParsingService::IsNationalRow($row))
        {
            $national = new \Application\Models\Domain\National($statistics);
            $national->id = $lineContents[CrimeFileParsingService::locationId];

            return $national;
        }

        $area = new \Application\Models\Domain\Area($statistics);
        $area->id = $lineContents[CrimeFileParsingService::locationId];

        return $area;
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
