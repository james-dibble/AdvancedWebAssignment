<?php
namespace Application\Controllers;

class LocationsController extends \Library\Controller\APIController
{
    private $_locationService;
    
    public function __construct(\Application\Services\ILocationService $locationService)
    {
        $this->_locationService = $locationService;
    }

    public function GetRegions($format)
    {
        $regions = $this->_locationService->GetAllRegions();
        
        $response = new \Application\Models\Responses\GeographicLocationCollection($regions);
        
        return $this->BuildRespose($response, $format);
    }
}
?>