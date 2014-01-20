<?php
namespace Application\Models\Responses;

class RecordedCrimeStatistic extends UniqueCrimeStatistic
{
    public function __construct($id, $total)
    {
        $this->id = $id;
        $this->total = $total;
    }
}
?>