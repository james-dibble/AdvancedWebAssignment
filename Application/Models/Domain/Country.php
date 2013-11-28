<?php
namespace Application\Models\Domain;

class Country extends \Application\Models\Domain\GeographicReference
{    
    public $regions;
    
    public function __construct() 
    {
        $this->regions = array();
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