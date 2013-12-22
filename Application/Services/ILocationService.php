<?php
namespace Application\Services;

interface ILocationService
{
    function GetAllRegions();
    
    function GetAllCountries();
    
    function GetCountryForRegion(\Application\Models\Domain\Region $region);
}
?>