<?php
namespace Application\Models\Domain;

class CrimeCollection 
{
    public $year;
    public $region;
    public $national;
    public $england;
    public $wales;
    
    public function __construct()
    {
        $this->region = array();
        $this->national = array();
        
        $region1 = new \Application\Models\Domain\Region();
        $region1->id = 'North';
        $region1->total = 12345;
        
        $region2 = new \Application\Models\Domain\Region();
        $region2->id = 'South';
        $region2->total = 54321;
        
        array_push($this->region, $region1);
        array_push($this->region, $region2);
        
        $national = new \Application\Models\Domain\National();
        $national->id = 'British Transport Police';
        $national->total = 74947;
               
        array_push($this->national, $national);
        
        $this->england = new \Application\Models\Domain\CrimeStatistics();
        $this->england->total = 2342;
        
        $this->wales = new \Application\Models\Domain\CrimeStatistics();
        $this->wales->total = 0985;
    }
}
?>
