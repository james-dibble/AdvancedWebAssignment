<?php
namespace Application\Models\Responses;

class National extends UniqueCrimeStatistic
{    
    public function __construct(\Application\Models\Domain\National $national)
    {
        parent::__construct($national->name, $national->GetTotal());
    }
}
?>
