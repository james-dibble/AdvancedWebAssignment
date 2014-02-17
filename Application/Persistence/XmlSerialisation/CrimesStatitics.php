<?php
namespace Application\Persistence\XmlSerialisation;

class CrimesStatitics 
{
    public $country;
    public $national;
    
    public function __construct(\Application\Models\Domain\StatisticsCollection $stats)
    {
        $this->country = array();
        $this->national = array();
        
        foreach($stats->countires as $country)
        {
            array_push($this->country, new \Application\Persistence\XmlSerialisation\Country($country));
        }
        
        foreach($stats->nationals as $national)
        {
            array_push($this->national, new \Application\Persistence\XmlSerialisation\National($national));
        }
    }
}
?>