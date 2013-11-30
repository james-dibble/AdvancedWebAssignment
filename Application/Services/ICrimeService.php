<?php
namespace Application\Services;

interface ICrimeService 
{
    function GetCrimesForAllRegions($year);
    
    function GetCrimesForRegion($year, $region);
}
?>
