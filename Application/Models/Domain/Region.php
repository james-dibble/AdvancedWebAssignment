<?php
namespace Application\Models\Domain;

class Region extends \Application\Models\Domain\GeographicReference
{   
    public $areas;
    
    public function __construct() 
    {
        $this->areas = array();
    }
    
    public function GetTotal() 
    {
        $total = 0;
        
        foreach($this->areas as $area)
        {
            $total += $area->GetTotal();
        }
        
        return $total;
    }   
}
?>
