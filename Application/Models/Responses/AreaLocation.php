<?php
namespace Application\Models\Responses;

class AreaLocation
{
    public $name;
    public $areas;
    
    public function __construct(\Application\Models\Domain\Area $area)
    {
        $this->name = $area->name;
    }
}
?>