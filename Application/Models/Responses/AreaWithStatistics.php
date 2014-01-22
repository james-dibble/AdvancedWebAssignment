<?php
namespace Application\Models\Responses;

class AreaWithStatistics extends Area
{
    public $recorded;
    
    public function __construct(\Application\Models\Domain\Area $area)
    {        
        parent::__construct($area);
        
        $this->recorded = array();
        
        foreach($area->crimeStatistics as $value)
        {
            if($value->value == null || $value->value == 0)
            {
                continue;
            }
            
            array_push($this->recorded, new RecordedCrimeStatistic($value));
        }
    }
}
?>