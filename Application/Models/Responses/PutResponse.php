<?php
namespace Application\Models\Responses;

class PutResponse
{
    public $area;
    
    public function __construct(\Application\Models\Domain\Area $originalArea, \Application\Models\Domain\Area $updatedArea, array $updatedStatistics)
    {
        $this->area = new \Application\Models\Responses\AreaWithUpdatedStatistics($originalArea, $updatedArea, $updatedStatistics);
    }
}
?>