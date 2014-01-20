<?php
namespace Application\Models\Responses;

class GeographicLocationCollection
{
    public $location;
    
    public function __construct(array $locations)
    {
        $this->location = array();
        foreach($locations as $location)
        {
            array_push($this->location, new GeographicLocationName($location));
        }
    }
}
?>
