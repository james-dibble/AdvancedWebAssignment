<?php
namespace Application\Services;

interface ICrimeService 
{   
    function ClearCrimes();
    
    function GetArea($areaName);
    
    function GetAllCrimeTypes();
    
    function GetCrimeType($abbreviation);
    
    function GetCrimesForAllRegions($year);
    
    function GetCrimesForRegion($year, $region);
    
    function GetCrimesForAllNationalStatistics($year);
    
    function GetCrimesForCountry($year, $country);
                
    function SaveStatistics(\Application\Models\Domain\StatisticsCollection $crimeStatistics);
    
    function SaveArea(\Application\Models\Domain\Area $area, \Application\Models\Domain\Region $region);
    
    function DeleteArea(\Application\Models\Domain\Area $area);
}
?>
