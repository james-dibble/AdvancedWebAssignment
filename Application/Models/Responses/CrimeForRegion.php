<?php
namespace Application\Models\Responses;

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
