<?php
namespace Application\Models\Responses;

class Area extends \Application\Models\Responses\UniqueCrimeStatistic
{
    public function __construct(\Application\Models\Domain\Area $area)
    {
        parent::__construct($area->id, $area->GetTotal());
    }
}
?>