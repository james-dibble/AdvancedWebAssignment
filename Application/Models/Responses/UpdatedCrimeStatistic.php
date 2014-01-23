<?php
namespace Application\Models\Responses;

class UpdatedCrimeStatistic extends \Application\Models\Responses\UniqueCrimeStatistic
{
    public $previous;
    
    public function __construct(\Application\Models\Domain\CrimeStatistic $statistic, \Application\Models\Domain\CrimeStatistic $updatedStatistic)
    {
        parent::__construct($statistic->type->name, $updatedStatistic->value);
        
        $this->previous = $statistic->value;
    }
}
?>
