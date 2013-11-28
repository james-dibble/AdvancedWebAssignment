<?php

namespace Application\Models\Domain;

class CrimeForRegion
{
    public $region;

    public function __construct() 
    {
        $this->region = new \Application\Models\Domain\RegionWithAreas();
        $this->region->total = 87348;
    }
}
?>
