<?php
namespace Application\Models\Responses;

abstract class CrimeStatistic
{
    public $total;
    
    public function __construct($total)
    {
        $this->total = $total;
    }
}
?>
