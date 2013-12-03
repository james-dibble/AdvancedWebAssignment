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
        $region = 
                $this->_persistence->Get(
                        new \Library\Persistence\PersistenceSearcher(
                            new \ReflectionClass('\Application\Models\Domain\Region'), array('ById' => $region)));
                
        return $region;
    }

    public function GetCrimesForAllNationalStatistics($year)
    {
        $crimes = 
                $this->_persistence->GetCollection(
                        new \Library\Persistence\PersistenceSearcher(
                            new \ReflectionClass('\Application\Models\Domain\National'), array()));
        
        return $crimes;
    }

    public function GetCrimesForCountry($year, $country)
    {   
        $country = 
                $this->_persistence->Get(
                        new \Library\Persistence\PersistenceSearcher(
                            new \ReflectionClass('\Application\Models\Domain\Country'), array('ById' => $country)));
                
        return $country;
    }
}
?>
