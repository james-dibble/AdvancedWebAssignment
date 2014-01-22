<?php
namespace Application\Models\Responses;

class LocationCollection
{
    public $location;
    
    public function __construct(array $regions)
    {
        $this->location = array();
        foreach($regions as $region)
        {
            array_push($this->location, new \Application\Models\Responses\RegionLocation($region));
        }
    }
}
?>