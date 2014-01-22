<?php
namespace Application\Models\Responses;

class DeletedCrimeStatistic extends UniqueCrimeStatistic
{
    public function __construct(\Application\Models\Domain\CrimeStatistic $statistic)
    {
        $this->id = $statistic->type->name;
        $this->total = $statistic->value;
    }
}
?>