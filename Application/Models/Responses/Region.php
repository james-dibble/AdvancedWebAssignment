<?php
namespace Application\Models\Responses;

class Region extends UniqueCrimeStatistic
{
    public function __construct(\Application\Models\Domain\Region $region)
    {
        parent::__construct($region->id, $region->GetTotal());
    }
}
?>
