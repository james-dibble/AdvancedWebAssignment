<?php
namespace Application\Controllers;

class CrimesController extends \Library\Controller\APIController
{
    private $_crimeService;
    
    public function __construct(\Application\Services\ICrimeService $crimeService) 
    {
        $this->_crimeService = $crimeService;
    }

    public function Get($year, $format)
    {
        $response = new \Application\Models\Responses\Response();
        
        $regionalCrimes = $this->_crimeService->GetCrimesForAllRegions($year);
                        
        $nationalCrimes = $this->_crimeService->GetCrimesForAllNationalStatistics($year);
        
        $englandCrimes = $this->_crimeService->GetCrimesForCountry($year, 'England');
        $walesCrimes = $this->_crimeService->GetCrimesForCountry($year, 'Wales');
                                
        $response->crimes = new \Application\Models\Responses\CrimeCollection($year, $regionalCrimes, $nationalCrimes, $englandCrimes, $walesCrimes);
        
        return CrimesController::BuildRespose($response, $format);
    }
    
    public function GetForRegion($year, $region, $format)
    {
        $escapedRegionName = str_replace('-', ' ', $region);
        
        $response = new \Application\Models\Responses\Response();
        
        $regionalCrimes = $this->_crimeService->GetCrimesForRegion($year, $escapedRegionName);
                
        $response->crimes = new \Application\Models\Responses\RegionalCrimeCollection($year, $regionalCrimes);
        
        return CrimesController::BuildRespose($response, $format);
    }
}
?>
