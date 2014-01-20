<?php
namespace Application\Models\Domain;

class StatisticsCollection
{
    public $countires;
    public $nationals;
    
    public function __construct()
    {
        $this->countires = array();
        $this->nationals = array();
    }
}
?>
