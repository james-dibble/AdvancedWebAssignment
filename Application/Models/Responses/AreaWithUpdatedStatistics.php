<?php
namespace Application\Models\Responses;

class AreaWithUpdatedStatistics extends Area
{
    public $previous;
    public $updated;
    
    public function __construct(\Application\Models\Domain\Area $area, \Application\Models\Domain\Area $updatedArea, array $updatedStatistics)
    {
        parent::__construct($updatedArea);
    
        $this->updated = array();
        
        foreach($updatedStatistics as $statistic)
        {
            array_push($this->updated, new UpdatedCrimeStatistic(AreaWithUpdatedStatistics::GetOriginalStatistic($area, $statistic), $statistic));
        }
        
        $this->previous = $area->GetTotal();
    }
    
    private static function GetOriginalStatistic(\Application\Models\Domain\Area $area, \Application\Models\Domain\CrimeStatistic $updatedStatistic)
    {
        foreach($area->crimeStatistics as $originalStatistic)
        {
            if($originalStatistic->type->id == $updatedStatistic->type->id)
            {
                return $originalStatistic;
            }
        }
        
        return null;
    }
}
?>
