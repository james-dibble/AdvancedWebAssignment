<?php
namespace Application\Models\Responses;

class CrimeCollection 
{
    public $year;
    public $region;
    public $national;
    public $england;
    public $wales;
    
    public function __construct($year, array $regions, array $nationals, \Application\Models\Domain\Country $england, \Application\Models\Domain\Country $wales)
    {
        $this->year = $year;
        
        $this->region = array();
        foreach($regions as $region)        
        {
            array_push($this->region, new \Application\Models\Responses\Region($region));
        }
        
        $this->national = array();
        foreach($nationals as $national)        
        {
            array_push($this->national, new \Application\Models\Responses\National($national));
        }
        
        $this->england = new \Application\Models\Responses\Country($england);
        
        $this->wales = new \Application\Models\Responses\Country($wales);
    }
}
?>
