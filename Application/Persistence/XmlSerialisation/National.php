<?php
namespace Application\Persistence\XmlSerialisation;

class National 
{
    public $name;
    public $statistic;
    
    public function __construct(\Application\Models\Domain\National $national)
    {
        $this->statistic = array();
        
        $this->name = $national->name;
        
        foreach($national->crimeStatistics as $crimeStatistic)
        {
            array_push($this->statistic, new CrimeStatistic($crimeStatistic));
        }
    }
}
?>