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
    private static $_nationals = array('British Transport Police');
        
    public function ParseFile(array $fileContents)
    {
        $statistics = new \Application\Models\Domain\StatisticsCollection();
        
        $currentCountry = new \Application\Models\Domain\Country();
        $currentRegion = new \Application\Models\Domain\Region();
        
        foreach($fileContents as $row)
        {
            if(CrimeFileParsingService::IsCountryRow($row))
            {
                $currentCountry->id = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];
                
                if(count($currentCountry->regions) == 0)
                {
                    $currentRegion->id = $currentCountry->id;
                
                    array_push($currentCountry->regions, $currentRegion);
                }
                
                array_push($statistics->countires, $currentCountry);
                
                $currentCountry = new \Application\Models\Domain\Country();
                continue;
            }
            
            if(CrimeFileParsingService::IsRegionRow($row))
            {
                $currentRegion->id = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];
                
                array_push($currentCountry->regions, $currentRegion);
                
                $currentRegion = new \Application\Models\Domain\Region();
                continue;
            }
            
            if(CrimeFileParsingService::IsNationalRow($row))
            {
                $national = $this->ParseArea($row);
                
                array_push($statistics->nationals, $national);
                continue;
            }
            
            $area = $this->ParseArea($row);
            
            if($area != null)
            {
                array_push($currentRegion->areas, $area);
            }
        }
        
        return $statistics;
    }  
    
    private function ParseArea($row)
    {
        if(preg_match('/^,+$/', $row))
        {
            return null;
        }
        
        if(!preg_match('/^([A-Za-z,\\-" ]+)((([,]+)(([\\d]{1,3})|(["]{1}[\\d]{1,3}[,]{1}[\\d]{3}["]{1})))+)$/', $row))
        {
            return null;
        }
                        
        $area = new \Application\Models\Domain\Area();
        
        if(CrimeFileParsingService::IsNationalRow($row))
        {
            $area = new \Application\Models\Domain\National();
        }
        
        $lineContents = CrimeFileParsingService::SplitRow($row);
        
        try
        {
            $area->id = $lineContents[CrimeFileParsingService::locationId];
            $area->homocide = $lineContents[CrimeFileParsingService::homocide];
            $area->violenceWithInjury = $lineContents[CrimeFileParsingService::violenceWithInjury];
            $area->violenceWithoutInjury = $lineContents[CrimeFileParsingService::violenceWithoutInjury];
            $area->sexualOffenses = $lineContents[CrimeFileParsingService::sexualOffenses];
            $area->robbery = $lineContents[CrimeFileParsingService::robbery];
            $area->theftOffenses = $lineContents[CrimeFileParsingService::theftOffenses];
            $area->domesticBurglary = $lineContents[CrimeFileParsingService::domesticBurglary];
            $area->nonDomesticBurglary = $lineContents[CrimeFileParsingService::nonDomesticBurglary];
            $area->vehicleOffenses = $lineContents[CrimeFileParsingService::vehicleOffenses];
            $area->theftFromPerson = $lineContents[CrimeFileParsingService::theftFromPerson];
            $area->bicycleTheft = $lineContents[CrimeFileParsingService::bicycleTheft];
            $area->shoplifting = $lineContents[CrimeFileParsingService::shoplifting];
            $area->miscTheft = $lineContents[CrimeFileParsingService::miscTheft];
            $area->criminalDamageAndArson = $lineContents[CrimeFileParsingService::criminalDamageAndArson];
            $area->drugOffenses = $lineContents[CrimeFileParsingService::drugOffenses];
            $area->possesionOfWeapons = $lineContents[CrimeFileParsingService::possesionOfWeapons];
            $area->publicOrderOffenses = $lineContents[CrimeFileParsingService::publicOrderOffenses];
            $area->miscCrimes = $lineContents[CrimeFileParsingService::miscCrimes];
            $area->fruad = $lineContents[CrimeFileParsingService::fruad];
        }
        catch(Exception $ex)
        {
            return null;
        }
        
        return $area;
    }
        
    private static function SplitRow($row)
    {
        $lineContents = array();
        
        foreach(str_getcsv($row) as $element)
        {
            array_push($lineContents, str_replace('..', '0', str_replace(',', '', $element)));
        }
        
        return $lineContents;
    }

    private static function IsCountryRow($row)
    {
        $possibleCountry = CrimeFileParsingService::SplitRow($row)[0];
        
        return CrimeFileParsingService::in_arrayi($possibleCountry, CrimeFileParsingService::$_countries);
    }
    
    private static function IsRegionRow($row)
    {
        $possibleRegion = CrimeFileParsingService::SplitRow($row)[0];
        
        return preg_match('/^[A-Za-z ]+ Region$/', $possibleRegion);
    }
    
    private static function IsNationalRow($row)
    {
        $possibleNational = CrimeFileParsingService::SplitRow($row)[0];
        
        return CrimeFileParsingService::in_arrayi($possibleNational, CrimeFileParsingService::$_nationals);
    }
        
    // From: http://uk.php.net/manual/en/function.in-array.php#89256
    private static function in_arrayi($needle, $haystack) 
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
}
?>