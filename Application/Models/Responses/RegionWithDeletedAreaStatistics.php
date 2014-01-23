<?php
namespace Application\Models\Responses;

class RegionWithDeletedAreaStatistics extends \Application\Models\Responses\Region
{
    public $area;
    
    public function __construct(\Application\Models\Domain\Region $region, \Application\Models\Domain\Area $area)
    {
        parent::__construct($region);
        
        $this->area = array(new AreaWithDeletedStatistics($area));
    }
}
?>