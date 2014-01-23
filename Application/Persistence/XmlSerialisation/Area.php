<?php
namespace Application\Persistence\XmlSerialisation;

class Area 
{
    public $name;
    public $statistic;
    
    public function __construct(\Application\Models\Domain\Area $area)
    {
        $this->statistic = array();
        
        $this->name = $area->name;
        
        foreach($area->crimeStatistics as $crimeStatistic)
        {
            array_push($this->statistic, new CrimeStatistic($crimeStatistic));
        }
    }
}
?>