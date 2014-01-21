<?php
namespace Application\Models\Responses;

class GeographicLocationName
{
    public $name;
    
    public function __construct(\Application\Models\Domain\GeographicReference $location)
    {
        $this->name = $location->name;
    }
}
?>