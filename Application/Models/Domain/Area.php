<?php
namespace Application\Models\Domain;

class Area extends \Application\Models\Domain\GeographicReference 
{
    public $crimeStatistics;
    public $region;
    
    public function __construct()
    {
        $this->crimeStatistics = array();
    }
    
    public function GetTotal()
    {
        $total = 0;
        
        foreach($this->crimeStatistics as $crimeStatistic)
        {
            $total += $crimeStatistic->value;
        }
        
        return $total;
    }
    
    public function HasStatistic(\Application\Models\Domain\CrimeStatisticType $type)
    {
        foreach($this->crimeStatistics as $statistic)
        {
            if($statistic->type->id == $type->id)
            {
                return true;
            }
        }
        
        return false;
    }
}
?>