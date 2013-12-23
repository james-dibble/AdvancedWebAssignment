<?php
namespace Application\Models\Responses;

class PostResponse
{
    public $region;
    public $england_wales;
    
    public function __construct(\Application\Models\Domain\Area $area, \Application\Models\Domain\Region $region, \Application\Models\Domain\Country $country, array $allCountries)
    {
        $this->region = new \Application\Models\Responses\RegionWithAreaStatistics($region, $area);
        
        $countryProperty = $country->id;
        
        $this->$countryProperty = new \Application\Models\Responses\Country($country);
        
        $this->england_wales = new \Application\Models\Responses\AllCountriesStatistic($allCountries);
    }
}
?>