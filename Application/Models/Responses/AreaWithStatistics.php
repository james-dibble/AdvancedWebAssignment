<?php
namespace Application\Models\Responses;

class AreaWithStatistics 
{
    public function __construct(\Application\Models\Domain\Area $area)
    {
        foreach($area->crimeStatistics as $key => $value)
        {
            $this->$key = $value;
        }
    }
}
?>