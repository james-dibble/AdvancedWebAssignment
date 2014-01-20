<?php
namespace Application\Models\Responses;

class Country extends CrimeStatistic
{    
    public function __construct(\Application\Models\Domain\Country $country)
    {
        parent::__construct($country->GetTotal());
    }
}
?>
