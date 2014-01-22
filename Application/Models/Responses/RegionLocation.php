<?php
namespace Application\Models\Responses;

class RegionLocation
{
    public $name;
    public $areas;
    
    public function __construct(\Application\Models\Domain\Region $region)
    {
        $this->name = $region->name;
        
        $this->areas = array();
        foreach($region->areas as $area)
        {
            array_push($this->areas, new \Application\Models\Responses\AreaLocation($area));
        }
    }
}
?>