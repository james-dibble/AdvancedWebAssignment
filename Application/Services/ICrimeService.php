<?php
namespace Application\Services;

interface ICrimeService 
{
    function GetCrimesForAllAreas($year);
    
    function GetCrimesForRegion($year, $region);
}
?>
