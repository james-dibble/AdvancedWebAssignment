<?php
namespace Application\Models\Responses;

class DeletedAreaWithStatistics extends Area
{
    public $deleted;
    
    public function __construct(\Application\Models\Domain\Area $area)
    {        
        parent::__construct($area);
        
        $this->deleted = array();
        
        foreach($area->crimeStatistics as $value)
        {
            if($value->value == null || $value->value == 0)
            {
                continue;
            }
            
            array_push($this->deleted, new RecordedCrimeStatistic($value));
        }
    }
}
?>