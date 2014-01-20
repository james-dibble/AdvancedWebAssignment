<?php
namespace Application\Models\Responses;

abstract class UniqueCrimeStatistic extends CrimeStatistic
{
    public $id;
    
    public function __construct($id, $total)
    {
        parent::__construct($total);
        $this->id = $id;
    }
}

?>
