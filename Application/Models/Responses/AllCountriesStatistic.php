<?php
namespace Application\Models\Responses;

class AllCountriesStatistic extends \Application\Models\Responses\CrimeStatistic
{
    public function __construct(array $countries)
    {
        $countryTotal = 0;
        
        foreach($countries as $countryForTotal)
        {
            $countryTotal += $countryForTotal->GetTotal();
        }
        
        parent::__construct($countryTotal);
    }
}
?>