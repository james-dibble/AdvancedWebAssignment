<?php
namespace Application\Persistence\XmlSerialisation;

class CrimesStatitics 
{
    public $country;
    
    public function __construct(\Application\Models\Domain\StatisticsCollection $stats)
    {
        $this->country = array();
        
        foreach($stats->countires as $country)
        {
            array_push($this->country, new \Application\Persistence\XmlSerialisation\Country($country));
        }
    }
}
?>