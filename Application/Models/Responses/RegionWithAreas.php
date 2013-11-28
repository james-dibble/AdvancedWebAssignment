<?php
namespace Application\Models\Responses;

class RegionWithAreas
{
    public $area;
    public $id;
    
    public function __construct()
    {
        $this->area = array();
        
        $area1 = new \Application\Models\Domain\Area();
        $area1->id = 'Wessex';
        $area1->total = 8962;
        
        array_push($this->area, $area1);
    }
}
?>
