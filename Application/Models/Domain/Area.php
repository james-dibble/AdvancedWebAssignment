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
}
?>