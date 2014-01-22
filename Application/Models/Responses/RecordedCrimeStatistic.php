<?php
namespace Application\Models\Responses;

class RecordedCrimeStatistic extends UniqueCrimeStatistic
{
    public function __construct(\Application\Models\Domain\CrimeStatistic $statistic)
    {
        $this->id = $statistic->type->name;
        $this->total = $statistic->value;
    }
}
?>