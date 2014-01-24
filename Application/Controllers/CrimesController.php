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
    
    public function GetCrimeTypes($format)
    {
        $response = new \Application\Models\Responses\Response();
        
        $crimeTypes = $this->_crimeService->GetAllCrimeTypes();
        
        $response->crimes = $crimeTypes;
        
        return $this->BuildRespose($response, $format);
    }
    
    public function GetForRegion($year, $region, $format)
    {
        $escapedRegionName = str_replace('_', ' ', $region);
        
        $response = new \Application\Models\Responses\Response();
        
        $regionalCrimes = $this->_crimeService->GetCrimesForRegion($year, $escapedRegionName);
                
        $response->crimes = new \Application\Models\Responses\RegionalCrimeCollection($year, $regionalCrimes);
        
        return $this->BuildRespose($response, $format);
    }
    
    public function GetForArea($year, $areaName, $format)
    {
        $area = $this->_crimeService->GetArea(str_replace('_', ' ', $areaName));
        
        $response = new \Application\Models\Responses\Response();
        
        $response->crimes = $area;
                
        return $this->BuildRespose($response, $format);
    }
    
    public function Post($regionName, $newArea, $areaData, $format)
    {
        $region = $this->_crimeService->GetCrimesForRegion(null, str_replace('_', ' ', $regionName));
           
        $area = new \Application\Models\Domain\Area();
        $area->name = $newArea;
        
        $areaDataSplit = explode('-', $areaData);
        
        foreach($areaDataSplit as $areaCrimeStatistic)
        {
            $crimeStatisticSplit = explode(':', $areaCrimeStatistic);
            
            $crimeStatisticType = $this->_crimeService->GetCrimeType($crimeStatisticSplit[0]);
            
            $crimeStatistic = new \Application\Models\Domain\CrimeStatistic($crimeStatisticSplit[1], $crimeStatisticType, $area);
            
            array_push($area->crimeStatistics, $crimeStatistic);
        }
                
        $this->_crimeService->SaveArea($area, $region);
        
        $country = $this->_locationService->GetCountryForRegion($region);
        $allCountries = $this->_locationService->GetAllCountries();
        
        $response = new \Application\Models\Responses\Response();
        $response->crimes = new \Application\Models\Responses\PostResponse($area, $region, $country, $allCountries);
        
        return $this->BuildRespose($response, $format);
    }
    
    public function Put($regionName, $areaName, $changedStatistics, $format)
    {           
        $area = $this->_crimeService->GetArea(str_replace('_', ' ', $areaName));
        
        $areaDataSplit = explode('-', $changedStatistics);
        
        $changedStatisticsModels = array();
        
        foreach($areaDataSplit as $areaCrimeStatistic)
        {
            $crimeStatisticSplit = explode(':', $areaCrimeStatistic);
            
            $crimeStatisticType = $this->_crimeService->GetCrimeType($crimeStatisticSplit[0]);
            
            $crimeStatistic = new \Application\Models\Domain\CrimeStatistic($crimeStatisticSplit[1], $crimeStatisticType, $area);
            
            array_push($changedStatisticsModels, $crimeStatistic);
        }
                
        $this->_crimeService->ChangeStatistics($changedStatisticsModels);
        
        $updatedArea = $this->_crimeService->GetArea(str_replace('_', ' ', $areaName));
        
        $response = new \Application\Models\Responses\Response();
        
        $response->crimes = new \Application\Models\Responses\PutResponse($area, $updatedArea, $changedStatisticsModels);
        
        return $this->BuildRespose($response, $format);
    }
    
    public function Delete($year, $format, $areaName)
    {
        $areaToDelete = $this->_crimeService->GetArea(str_replace('_', ' ', $areaName));
        
        $this->_crimeService->DeleteArea($areaToDelete);
        
        $region = $this->_crimeService->GetCrimesForRegion(null, $areaToDelete->region->name);
        
        $country = $this->_locationService->GetCountryForRegion($region);
        $allCountries = $this->_locationService->GetAllCountries();
        
        $response = new \Application\Models\Responses\Response();
        
        $response->crimes = new \Application\Models\Responses\DeleteResponse($areaToDelete, $region, $country, $allCountries);
        
        return $this->BuildRespose($response, $format);
    }
}
?>
