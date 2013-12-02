<?php
namespace Application\Models\Domain;

class National extends \Application\Models\Domain\Area
{
    public function __construct(\Application\Models\Domain\CrimeStatistics $crimeStatistics)
    {
        parent::__construct($crimeStatistics);
    }
}
?>
