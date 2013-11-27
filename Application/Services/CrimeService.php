<?php
namespace Application\Services;

class CrimeService implements ICrimeService 
{
    public function GetCrimesForAllAreas($year) 
    {
        $crimes = new \Application\Models\Domain\CrimeCollection();
        $crimes->year = $year;
        
        return $crimes;
    }    
    
    public function GetCrimesForRegion($year, $region)
    {
        $crimes = new \Application\Models\Domain\CrimeForRegion();
        
        $crimes->year = $year;
        $crimes->region->id = $region;
        
        return $crimes;
    }
}
?>
