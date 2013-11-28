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
    const possesionOfWeapons = 23;
    const publicOrderOffenses = 24;
    const miscCrimes = 25;
    const fruad = 27;
    private static $_countries = array('England', 'Wales');
        
    public function ParseFile(array $fileContents)
    {
        $countries = array();
        $currentCountry = new \Application\Models\Domain\Country();
        $currentRegion = new \Application\Models\Domain\Region();
        
        foreach($fileContents as $row)
        {
            if(CrimeFileParsingService::IsCountryRow($row))
            {
                $currentCountry->id = CrimeFileParsingService::SplitRow($row)[CrimeFileParsingService::locationId];
                
                array_push($countries, $currentCountry);
                
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
            
            $area = $this->ParseArea($row);
            
            if($area != null)
            {
                array_push($currentRegion->areas, $area);
            }
        }
        
        return $countries;
    }  
    
    private function ParseArea($row)
    {
        if(preg_match('^,+$', $row))
        {
            return null;
        }
        
        if(!preg_match('^([A-Za-z,\\-" ]+)((([,]+)(([\\d]{1,3})|(["]{1}[\\d]{1,3}[,]{1}[\\d]{3}["]{1})))+)$', $row))
        {
            return null;
        }
        
        $area = new \Application\Models\Domain\Area();
        
        $lineContents = CrimeFileParsingService::SplitRow($row);
        
        try
        {
            $action->id = $lineContents[CrimeFileParsingService::locationId];
            $action->homocide = $lineContents[CrimeFileParsingService::homocide];
            $action->violenceWithInjury = $lineContents[CrimeFileParsingService::violenceWithInjury];
            $action->violenceWithoutInjury = $lineContents[CrimeFileParsingService::violenceWithoutInjury];
            $action->sexualOffenses = $lineContents[CrimeFileParsingService::sexualOffenses];
            $action->robbery = $lineContents[CrimeFileParsingService::robbery];
            $action->theftOffenses = $lineContents[CrimeFileParsingService::theftOffenses];
            $action->domesticBurglary = $lineContents[CrimeFileParsingService::domesticBurglary];
            $action->nonDomesticBurglary = $lineContents[CrimeFileParsingService::nonDomesticBurglary];
            $action->vehicleOffenses = $lineContents[CrimeFileParsingService::vehicleOffenses];
            $action->theftFromPerson = $lineContents[CrimeFileParsingService::theftFromPerson];
            $action->bicycleTheft = $lineContents[CrimeFileParsingService::bicycleTheft];
            $action->shoplifting = $lineContents[CrimeFileParsingService::shoplifting];
            $action->miscTheft = $lineContents[CrimeFileParsingService::miscTheft];
            $action->criminalDamageAndArson = $lineContents[CrimeFileParsingService::criminalDamageAndArson];
            $action->drugOffenses = $lineContents[CrimeFileParsingService::drugOffenses];
            $action->possesionOfWeapons = $lineContents[CrimeFileParsingService::possesionOfWeapons];
            $action->publicOrderOffenses = $lineContents[CrimeFileParsingService::publicOrderOffenses];
            $action->miscCrimes = $lineContents[CrimeFileParsingService::miscCrimes];
            $action->fruad = $lineContents[CrimeFileParsingService::fruad];
        }
        catch(Exception $ex)
        {
            return null;
        }
        
        return $area;
    }
        
    private static function SplitRow($row)
    {
        $lineContents = str_getcsv($row);
        
        return $lineContents;
    }

    private static function IsCountryRow($row)
    {
        $possibleCountry = CrimeFileParsingService::SplitRow($row)[0];
        
        return in_arrayi($possibleCountry, CrimeFileParsingService::$_countries);
    }
    
    private static function IsRegionRow($row)
    {
        $possibleRegion = CrimeFileParsingService::SplitRow($row)[0];
        
        return preg_match('^[A-Za-z ]+ Region$', $possibleRegion);
    }
        
    // From: http://uk.php.net/manual/en/function.in-array.php#89256
    private static function in_arrayi($needle, $haystack) 
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
}
?>