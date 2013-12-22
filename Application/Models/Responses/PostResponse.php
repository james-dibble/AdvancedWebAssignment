<?php
namespace Application\Models\Responses;

class PostResponse
{
    public $region;
    public $england_wales;
    
    public function __construct(\Application\Models\Domain\Region $region, \Application\Models\Domain\Country $country, array $allCountries)
    {
        $this->region = new \Application\Models\Responses\Region($region);
        
        $countryProperty = $country->id;
        
        $this->$countryProperty = $country->GetTotal();
        
        $countryTotal = 0;
        
        foreach($allCountries as $countryForTotal)
        {
            $countryTotal += $countryForTotal->GetTotal();
        }
        
        $this->england_wales = $countryTotal;
    }
}
?>