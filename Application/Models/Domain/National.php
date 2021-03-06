<?php
namespace Application\Models\Domain;

class National extends \Application\Models\Domain\GeographicReference 
{
    public $crimeStatistics;
    
    public function __construct()
    {
        $this->crimeStatistics = array();
    }
    
    public function GetTotal()
    {
        $total = 0;
        
        foreach($this->crimeStatistics as $crimeStatistic)
        {
            $total += $crimeStatistic->GetTotal();
        }
        
        return $total;
    }
}
?>