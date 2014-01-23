<?php
namespace Application\Persistence\XmlSerialisation;

class CrimeStatistic 
{
    public $type;
    public $total;
    
    public function __construct(\Application\Models\Domain\CrimeStatistic $crimeStatistic)
    {
        $this->type = $crimeStatistic->type->name;
        $this->total = $crimeStatistic->value;
    }
}
?>