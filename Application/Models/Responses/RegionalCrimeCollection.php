<?php
namespace Application\Models\Responses;

class RegionalCrimeCollection
{
    public $year;
    public $region;
    
    public function __construct($year, \Application\Models\Domain\Region $region)
    {
        $this->year = $year;
        $this->region = new RegionWithAreas($region);
    }
}
?>
