<?php
namespace Application\Persistence\XmlSerialisation;

class Region 
{
    public $name;
    public $area;
    
    public function __construct(\Application\Models\Domain\Region $region)
    {
        $this->area = array();
            
        $this->name = $region->name;
        
        foreach($region->areas as $area)
        {
            array_push($this->area, new \Application\Persistence\XmlSerialisation\Area($area));
        }
    }
}
?>