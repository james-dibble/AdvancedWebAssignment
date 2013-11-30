<?php
namespace Application\Services;

class CrimeService implements ICrimeService 
{
    private $_persistence;
    
    public function __construct(\Library\Persistence\IPersistenceManager $persistence)
    {
        $this->_persistence = $persistence;
    }

    public function GetCrimesForAllRegions($year) 
    {
        $crimes = 
                $this->_persistence->GetCollection(
                        new \Library\Persistence\PersistenceSearcher(
                            new \ReflectionClass('\Application\Models\Domain\Region'), array()));
        
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
