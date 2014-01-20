<?php
namespace Application\Services;

interface ICrimeService 
{   
    function GetCrimesForAllRegions($year);
    
    function GetCrimesForRegion($year, $region);
    
    function GetCrimesForAllNationalStatistics($year);
    
    function GetCrimesForCountry($year, $country);
                
    function SaveStatistics(\Application\Models\Domain\StatisticsCollection $crimeStatistics);
    
    function SaveArea(\Application\Models\Domain\Area $area, \Application\Models\Domain\Region $region);
}
?>
