<?php
namespace Application\Models\Domain;

class CrimeStatistic
{
    public $value;
    public $type;
    public $area;
    
    public function __construct($value, \Application\Models\Domain\CrimeStatisticType $type, \Application\Models\Domain\GeographicReference $area = null)
    {
        $this->value = $value;
        $this->type = $type;
        $this->area = $area;
    }
    
    public function GetTotal()
    {
        return $this->value;
    }
}
?>