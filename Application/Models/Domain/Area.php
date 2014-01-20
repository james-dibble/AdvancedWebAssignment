<?php
namespace Application\Models\Domain;

class Area extends \Application\Models\Domain\GeographicReference 
{
    public $crimeStatistics;
    
    public function __construct(\Application\Models\Domain\CrimeStatistics $crimeStatistics)
    {
        $this->crimeStatistics = $crimeStatistics;
    }
    
    public function GetTotal()
    {
        return $this->crimeStatistics->GetTotal();
    }
}
?>