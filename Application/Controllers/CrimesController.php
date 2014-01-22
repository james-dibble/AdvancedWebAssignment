<?php
namespace Application\Controllers;

class CrimesController extends \Library\Controller\APIController
{
    private $_crimeService;
    private $_locationService;


    public function __construct(\Application\Services\ICrimeService $crimeService, \Application\Services\ILocationService $locationService) 
    {
        $this->_crimeService = $crimeService;
        $this->_locationService = $locationService;
    }

    public function Get($year, $format)
    {
        $response = new \Application\Models\Responses\Response();
        
        $regionalCrimes = $this->_crimeService->GetCrimesForAllRegions($year);
                        
        $nationalCrimes = $this->_crimeService->GetCrimesForAllNationalStatistics($year);
        
        $englandCrimes = $this->_crimeService->GetCrimesForCountry($year, 'England');
        $walesCrimes = $this->_crimeService->GetCrimesForCountry($year, 'Wales');
                                
        $response->crimes = new \Application\Models\Responses\CrimeCollection($year, $regionalCrimes, $nationalCrimes, $englandCrimes, $walesCrimes);
        
        return $this->BuildRespose($response, $format);
    }
    
    public function GetForRegion($year, $region, $format)
    {
        $escapedRegionName = str_replace('-', ' ', $region);
        
        $response = new \Application\Models\Responses\Response();
        
        $regionalCrimes = $this->_crimeService->GetCrimesForRegion($year, $escapedRegionName);
                
        $response->crimes = new \Application\Models\Responses\RegionalCrimeCollection($year, $regionalCrimes);
        
        return $this->BuildRespose($response, $format);
    }
    
    public function Post($regionName, $newArea, $areaData, $format)
    {
        $region = $this->_crimeService->GetCrimesForRegion(null, str_replace('_', ' ', $regionName));
        
        $areaDataSplit = explode('-', $areaData);
        $areaDataDictionary = array();
        
        foreach($areaDataSplit as $areaCrimeStatistic)
        {
            $crimeStatistic = explode(':', $areaCrimeStatistic);
            
            $areaDataDictionary[$crimeStatistic[0]] = $crimeStatistic[1];
        }
        
        $homicide = array_key_exists('hom', $areaDataDictionary) ? $areaDataDictionary['hom'] : 0;
        $violenceWithInjury = array_key_exists('vwi', $areaDataDictionary) ? $areaDataDictionary['vwi'] : 0;
        $violenceWithoutInjury = array_key_exists('vwoi', $areaDataDictionary) ? $areaDataDictionary['vwoi'] : 0;
        
        $crimeStats = new \Application\Models\Domain\CrimeStatistics();
        $crimeStats->homocide = $homicide;
        $crimeStats->violenceWithInjury = $violenceWithInjury;
        $crimeStats->violenceWithoutInjury = $violenceWithoutInjury;
                
        $area = new \Application\Models\Domain\Area($crimeStats);
        $area->id = $newArea;
        
        $this->_crimeService->SaveArea($area, $region);
        
        $country = $this->_locationService->GetCountryForRegion($region);
        $allCountries = $this->_locationService->GetAllCountries();
        
        $response = new \Application\Models\Responses\Response();
        $response->crimes = new \Application\Models\Responses\PostResponse($area, $region, $country, $allCountries);
        
        return $this->BuildRespose($response, $format);
    }
}
?>
