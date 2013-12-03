<?php
namespace Application\Models\Responses;

class RegionWithAreas extends Region
{
    public $area;
    
    public function __construct(\Application\Models\Domain\Region $region)
    {
        parent::__construct($region);
        
        $this->area = array();        
        foreach($region->areas as $area)
        {
            array_push($this->area, new Area($area));
        }
    }
}
?>